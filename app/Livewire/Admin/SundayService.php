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
        'sunday_poster' => 'nullable|image|mimes:png,jpeg,jpg|max:2048', // 2MB max
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
        $this->service_date = $service->service_date;
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
            $posterPath = $this->sunday_poster->store('posters', 'public');
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

            // Upload new poster
            $posterPath = $this->sunday_poster->store('posters', 'public');
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
