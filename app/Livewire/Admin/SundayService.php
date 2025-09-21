<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\SundayService as SundayServiceModel;

#[Layout('layouts.admin')]
class SundayService extends Component
{
    use WithPagination;
    use WithFileUploads;

    // Ensure Livewire uses Bootstrap pagination templates (not Tailwind SVGs)
    public string $paginationTheme = 'bootstrap';

    public $sunday_theme;
    public $sunday_poster;
    public $service_date;
    public $service_time;
    public $service_id;
    public $current_poster; // To store current poster path for editing

    public $isModalOpen = false;
    public $isDeleteModalOpen = false;
    public $serviceToDelete = null;
    public $search = '';
    public $filterMonth = '';
    public $filterYear = '';

    protected $rules = [
        'sunday_theme' => 'required|string|max:255',
        'sunday_poster' => 'nullable|image|mimes:png,jpeg,jpg|max:10240', // Increased to 10MB as we'll resize if needed
        'service_date' => 'required|date',
        'service_time' => 'required',
    ];

    protected $messages = [
        'sunday_poster.required' => 'Please select a poster image.',
        'sunday_poster.image' => 'The file must be an image.',
        'sunday_poster.mimes' => 'The poster must be a PNG or JPEG file.',
        'sunday_poster.max' => 'The poster size must not exceed 2MB.',
        'service_date.unique_datetime' => 'A service already exists for this date and time.',
    ];

    protected function validateUniqueDateTime()
    {
        $query = SundayServiceModel::where('service_date', $this->service_date)
                                   ->where('service_time', $this->service_time);

        // If editing, exclude the current service from the check
        if ($this->service_id) {
            $query->where('id', '!=', $this->service_id);
        }

        if ($query->exists()) {
            $this->addError('service_date', 'A service already exists for this date and time.');
            return false;
        }

        return true;
    }

    /**
     * Resize image if it's larger than 2MB while maintaining quality
     */
    private function resizeImageIfNeeded($uploadedFile)
    {
        // If file is already under 2MB, return as is
        if ($uploadedFile->getSize() <= 2048 * 1024) { // 2MB in bytes
            return $uploadedFile;
        }

        try {
            $originalPath = $uploadedFile->getPathname();
            $imageInfo = getimagesize($originalPath);

            if (!$imageInfo) {
                return $uploadedFile; // Not a valid image, let validation handle it
            }

            $width = $imageInfo[0];
            $height = $imageInfo[1];
            $mimeType = $imageInfo['mime'];

            // Create image resource based on type
            switch ($mimeType) {
                case 'image/jpeg':
                    $sourceImage = imagecreatefromjpeg($originalPath);
                    break;
                case 'image/png':
                    $sourceImage = imagecreatefrompng($originalPath);
                    break;
                case 'image/jpg':
                    $sourceImage = imagecreatefromjpeg($originalPath);
                    break;
                default:
                    return $uploadedFile; // Unsupported format
            }

            if (!$sourceImage) {
                return $uploadedFile;
            }

            // Calculate new dimensions (reduce by 20% each time until under 2MB or max 3 iterations)
            $maxIterations = 3;
            $iteration = 0;
            $quality = 85; // Start with high quality

            do {
                $iteration++;
                $scaleFactor = 1 - ($iteration * 0.2); // Reduce by 20% each iteration
                $newWidth = (int)($width * $scaleFactor);
                $newHeight = (int)($height * $scaleFactor);

                // Ensure minimum dimensions
                if ($newWidth < 300 || $newHeight < 300) {
                    $newWidth = max(300, $newWidth);
                    $newHeight = max(300, $newHeight);
                }

                // Create new image
                $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

                // Preserve transparency for PNG
                if ($mimeType === 'image/png') {
                    imagealphablending($resizedImage, false);
                    imagesavealpha($resizedImage, true);
                    $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
                    imagefill($resizedImage, 0, 0, $transparent);
                }

                // Resize the image
                imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                // Create temporary file
                $tempPath = tempnam(sys_get_temp_dir(), 'resized_poster_');

                // Save based on original format
                $success = false;
                switch ($mimeType) {
                    case 'image/jpeg':
                    case 'image/jpg':
                        $success = imagejpeg($resizedImage, $tempPath, $quality);
                        break;
                    case 'image/png':
                        // PNG compression level (0-9, where 9 is max compression)
                        $pngQuality = 9 - (int)(($quality / 100) * 9);
                        $success = imagepng($resizedImage, $tempPath, $pngQuality);
                        break;
                }

                imagedestroy($resizedImage);

                if (!$success) {
                    if (file_exists($tempPath)) {
                        unlink($tempPath);
                    }
                    break;
                }

                $newSize = filesize($tempPath);

                // If under 2MB, create new UploadedFile and return
                if ($newSize <= 2048 * 1024) {
                    $originalName = $uploadedFile->getClientOriginalName();
                    $originalExtension = $uploadedFile->getClientOriginalExtension();

                    // Create new UploadedFile instance
                    $resizedUploadedFile = new \Illuminate\Http\UploadedFile(
                        $tempPath,
                        $originalName,
                        $mimeType,
                        null,
                        true // test mode to avoid file validation issues
                    );

                    imagedestroy($sourceImage);
                    return $resizedUploadedFile;
                }

                // Clean up temp file for next iteration
                if (file_exists($tempPath)) {
                    unlink($tempPath);
                }

                // Reduce quality for next iteration
                $quality = max(60, $quality - 10);

            } while ($iteration < $maxIterations);

            imagedestroy($sourceImage);

        } catch (\Exception $e) {
            // If resizing fails, return original file
            \Log::warning('Image resize failed: ' . $e->getMessage());
        }

        return $uploadedFile; // Return original if resizing failed
    }

    public function create()
    {
        $this->resetCreateForm();
        $this->openModal();
    }

    public function edit($id)
    {
        $service = SundayServiceModel::findOrFail($id);

        $this->service_id = $service->id;
        $this->sunday_theme = $service->sunday_theme;
        $this->service_date = \Carbon\Carbon::parse($service->service_date)->format('Y-m-d');
        $this->service_time = $service->service_time;
        $this->current_poster = $service->sunday_poster;
        $this->sunday_poster = null; // Reset file upload

        $this->openModal();
    }

    public function store()
    {
        // Validate the form data
        $this->validate();

        // Check for duplicate date/time combination
        if (!$this->validateUniqueDateTime()) {
            return;
        }

        // Handle file upload
        $posterPath = null;
        if ($this->sunday_poster) {
            // Resize image if needed
            $processedFile = $this->resizeImageIfNeeded($this->sunday_poster);
            $posterPath = $processedFile->store('posters', 'public');
        }

        // Create the service record
        SundayServiceModel::create([
            'sunday_theme' => $this->sunday_theme,
            'sunday_poster' => $posterPath,
            'service_date' => $this->service_date,
            'service_time' => $this->service_time,
            'user_email' => auth()->user()->email ?? null, // Assuming you want to store current user's email
        ]);

        //session()->flash('message', 'Sunday Service created successfully.');
        $this->dispatch('toastr-success', 'Sunday Service created successfully.');
        $this->dispatch('sunday-service-created');
        $this->closeModal();
        $this->resetCreateForm();
    }

    public function update()
    {
        // Modify validation rules for update - poster is optional if editing
        $updateRules = [
            'sunday_theme' => 'required|string|max:255',
            'sunday_poster' => 'nullable|image|mimes:png,jpeg,jpg|max:2048',
            'service_date' => 'required|date',
            'service_time' => 'required',
        ];

        $this->validate($updateRules);

        // Check for duplicate date/time combination (excluding current service)
        if (!$this->validateUniqueDateTime()) {
            return;
        }

        $service = SundayServiceModel::findOrFail($this->service_id);

        // Handle file upload for update
        $posterPath = $service->sunday_poster; // Keep existing poster by default

        if ($this->sunday_poster) {
            // Delete old poster if it exists
            if ($service->sunday_poster && Storage::disk('public')->exists($service->sunday_poster)) {
                Storage::disk('public')->delete($service->sunday_poster);
            }

            // Resize image if needed and upload new poster
            $processedFile = $this->resizeImageIfNeeded($this->sunday_poster);
            $posterPath = $processedFile->store('posters', 'public');
        }

        // Update the service record
        $service->update([
            'sunday_theme' => $this->sunday_theme,
            'sunday_poster' => $posterPath,
            'service_date' => $this->service_date,
            'service_time' => $this->service_time,
            'user_email' => auth()->user()->email ?? $service->user_email, // Update email or keep existing
        ]);

        //session()->flash('message', 'Sunday Service updated successfully.');
        $this->dispatch('toastr-success', 'Sunday Service updated successfully.');
        $this->dispatch('sunday-service-updated');
        $this->closeModal();
        $this->resetCreateForm();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetValidation(); // Clear validation errors
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterMonth()
    {
        $this->resetPage();
    }

    public function updatingFilterYear()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->filterMonth = '';
        $this->filterYear = '';
        $this->resetPage();
    }

    private function resetCreateForm()
    {
        $this->sunday_theme = '';
        $this->sunday_poster = null;
        $this->service_date = null;
        $this->service_time = null;
        $this->service_id = null;
        $this->current_poster = null;
        $this->resetValidation();
    }

    public function confirmDelete($id)
    {
        $this->serviceToDelete = SundayServiceModel::findOrFail($id);
        $this->isDeleteModalOpen = true;
    }

    public function closeDeleteModal()
    {
        $this->isDeleteModalOpen = false;
        $this->serviceToDelete = null;
    }

    public function delete()
    {
        try {
            if (!$this->serviceToDelete) {
                $this->dispatch('toastr-error', 'No service selected for deletion.');
                return;
            }

            // Delete the poster file if it exists
            if ($this->serviceToDelete->sunday_poster && Storage::disk('public')->exists($this->serviceToDelete->sunday_poster)) {
                Storage::disk('public')->delete($this->serviceToDelete->sunday_poster);
            }

            $this->serviceToDelete->delete();
            $this->dispatch('toastr-success', 'Service deleted successfully!');
            $this->dispatch('sunday-service-deleted');

            // Close the modal and reset
            $this->closeDeleteModal();
        } catch (\Exception $e) {
            $this->dispatch('toastr-error', 'Failed to delete service: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $query = SundayServiceModel::where('sunday_theme', 'like', '%'.$this->search.'%');

        // Apply month filter
        if ($this->filterMonth) {
            $query->whereMonth('service_date', $this->filterMonth);
        }

        // Apply year filter
        if ($this->filterYear) {
            $query->whereYear('service_date', $this->filterYear);
        }

        $services = $query->latest('service_date')->orderBy('service_time', 'asc')->paginate(9);

        return view('livewire.admin.sunday-service', ['services' => $services]);
    }
}
