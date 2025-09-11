<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Models\Testimony;
use App\Models\TestimonyImage;
use App\Models\User;
use App\Notifications\TestimonyAlert;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.main')]
class CreateTestimony extends Component
{
    use WithFileUploads;

    #[Title('Share Your Testimony')]
    public $description = "Share how God has moved in your life and inspire others with your testimony";

    // Form properties
    public $title = '';
    public $author = '';
    public $email = '';
    public $phone = '';
    public $result_category = '';
    public $testimony_date = '';
    public $engagements = [];
    public $content = '';
    public $publish_permission = false;

    // Image upload properties
    public $images = [];
    public $imageCaptions = [];

    // UI state
    public $showSuccessMessage = false;
    public $showConfirmationModal = false;
    public $submissionComplete = false;
    public $submittedTestimonyTitle = '';

    protected $rules = [
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'result_category' => 'required|string',
        'testimony_date' => 'nullable|date|before_or_equal:today',
        'engagements' => 'nullable|array',
        'content' => 'required|string|min:50',
        'publish_permission' => 'required|boolean|accepted',
        'images.*' => 'nullable|image|max:2048',
        'imageCaptions.*' => 'nullable|string|max:255'
    ];

    protected $messages = [
        'title.required' => 'Please enter a title for your testimony.',
        'author.required' => 'Please enter your name.',
        'email.required' => 'Please enter your email address.',
        'email.email' => 'Please enter a valid email address.',
        'result_category.required' => 'Please select a result category.',
        'content.required' => 'Please share your testimony.',
        'content.min' => 'Your testimony must be at least 50 characters long.',
        'publish_permission.accepted' => 'You must give permission to publish your testimony.'
    ];

    public function submitTestimony()
    {
        // First validate the form
        $this->validate();

        // Show confirmation modal instead of submitting directly
        $this->showConfirmationModal = true;
    }

    public function confirmSubmission()
    {
        // Validate again to be safe
        $this->validate();

        try {
            // Store the title for the success screen
            $this->submittedTestimonyTitle = $this->title;

            // Create the testimony
            $testimony = Testimony::create([
                'title' => $this->title,
                'author' => $this->author,
                'email' => $this->email,
                'phone' => $this->phone ?: null,
                'result_category' => $this->result_category,
                'testimony_date' => $this->testimony_date ?: null,
                'engagements' => $this->engagements,
                'content' => $this->content,
                'publish_permission' => $this->publish_permission,
                'status' => 'pending'
            ]);

            // Handle image uploads
            $this->handleImageUploads($testimony);

            // Send notification to admins
            $admins = User::whereIn('role', ['super_admin', 'administrator'])->get();
            $admins->each(function ($admin) use ($testimony) {
                try {
                    $admin->notify(new TestimonyAlert($testimony));
                } catch (\Exception $e) {
                    \Log::error("Failed to notify {$admin->email}: " . $e->getMessage());
                }
            });


            // Show success screen instead of redirecting
            $this->showConfirmationModal = false;
            $this->submissionComplete = true;

        } catch (\Exception $e) {
            session()->flash('error', 'There was an error submitting your testimony. Please try again.');
            \Log::error('Testimony submission error: ' . $e->getMessage());
            $this->showConfirmationModal = false;
        }
    }

    public function cancelSubmission()
    {
        $this->showConfirmationModal = false;
    }

    public function addAnotherTestimony()
    {
        // Reset the form and return to the form state
        $this->resetForm();
        $this->submissionComplete = false;
        $this->submittedTestimonyTitle = '';
    }

    public function goToTestimonies()
    {
        return redirect()->route('testimonies');
    }

    public function resetForm()
    {
        $this->reset([
            'title', 'author', 'email', 'phone', 'result_category',
            'testimony_date', 'engagements', 'content', 'publish_permission',
            'images', 'imageCaptions'
        ]);
        $this->resetValidation();
    }

    public function removeImage($index)
    {
        unset($this->images[$index]);
        unset($this->imageCaptions[$index]);
        $this->images = array_values($this->images);
        $this->imageCaptions = array_values($this->imageCaptions);
    }

    public function updatedImages()
    {
        // Limit to 3 images
        if (count($this->images) > 3) {
            $this->images = array_slice($this->images, 0, 3);
            session()->flash('warning', 'You can only upload a maximum of 3 images.');
        }

        // Validate each image (2MB = 2048 KB)
        $this->validate([
            'images.*' => 'image|max:2048'
        ]);
    }

    private function handleImageUploads(Testimony $testimony)
    {
        if (empty($this->images)) {
            return;
        }

        foreach ($this->images as $index => $image) {
            if ($image) {
                try {
                    // Store the image
                    $path = $image->store('testimony-images', 'public');

                    // Create testimony image record
                    TestimonyImage::create([
                        'testimony_id' => $testimony->id,
                        'image' => $path,
                        'caption' => $this->imageCaptions[$index] ?? null,
                        'sort_order' => $index + 1,
                        // Default to visible; admin can hide before approval
                        'is_approved' => true
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Image upload error: ' . $e->getMessage());
                }
            }
        }
    }

    public function getResultCategoriesProperty()
    {
        return [
            'Healing' => 'Healing',
            'Breakthrough' => 'Breakthrough',
            'Restoration' => 'Restoration',
            'Provision' => 'Provision',
            'Protection' => 'Protection',
            'Favour' => 'Favour',
            'Deliverance' => 'Deliverance',
            'Success' => 'Success',
            'Family' => 'Family',
            'Other' => 'Other'
        ];
    }

    public function getEngagementTypesProperty()
    {
        return [
            'Prayer' => 'Prayer',
            'Anointing' => 'Anointing',
            'Communion' => 'Communion',
            'Kingdom Service' => 'Kingdom Service',
            'Sowing of Seed' => 'Sowing of Seed',
            'Fasting' => 'Fasting',
            'Mantle' => 'Mantle',
            'Evangelism' => 'Evangelism'
        ];
    }

    public function render()
    {
        return view('livewire.public.create-testimony');
    }
}
