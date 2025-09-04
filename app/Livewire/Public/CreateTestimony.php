<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\Testimony;

#[Layout('layouts.main')]
class CreateTestimony extends Component
{
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
        'publish_permission' => 'required|boolean|accepted'
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
            Testimony::create([
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

            // Show success screen instead of redirecting
            $this->showConfirmationModal = false;
            $this->submissionComplete = true;

        } catch (\Exception $e) {
            session()->flash('error', 'There was an error submitting your testimony. Please try again.');
            $this->showConfirmationModal = false;
        }
    }    public function cancelSubmission()
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
            'testimony_date', 'engagements', 'content', 'publish_permission'
        ]);
        $this->resetValidation();
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
