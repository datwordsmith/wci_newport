<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\Testimony;

#[Layout('layouts.main')]
class Testimonies extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    #[Title('Testimonies')]
    public $description = "Discover the powerful testimonies of our members and how God is working in their lives";

    // Public filters/search
    public $resultFilter = 'all';
    public $engagementFilter = 'all';
    public $searchTerm = '';

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

    // Reset pagination when filters/search change
    public function updatingResultFilter() {
        $this->resetPage();
    }

    public function updatingEngagementFilter() {
        $this->resetPage();
    }

    public function updatingSearchTerm() {
        $this->resetPage();
    }

    public function updatedSearchTerm()
    {
        $this->resetPage();
        $this->dispatch('testimonies-updated');
    }

    public function updatedResultFilter()
    {
        $this->dispatch('testimonies-updated');
    }

    public function updatedEngagementFilter()
    {
        $this->dispatch('testimonies-updated');
    }

    public function submitTestimony()
    {
        $this->validate();

        try {
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

            // Reset form
            $this->reset([
                'title', 'author', 'email', 'phone', 'result_category',
                'testimony_date', 'engagements', 'content', 'publish_permission'
            ]);

            // Show success message
            $this->showSuccessMessage = true;

            // Dispatch browser event to close modal
            $this->dispatch('testimony-submitted');

            session()->flash('success', 'Thank you for sharing your testimony! It will be reviewed by our team before being published.');

        } catch (\Exception $e) {
            session()->flash('error', 'There was an error submitting your testimony. Please try again.');
        }
    }

    public function resetForm()
    {
        $this->reset([
            'title', 'author', 'email', 'phone', 'result_category',
            'testimony_date', 'engagements', 'content', 'publish_permission'
        ]);
        $this->resetValidation();
    }

    public function clearFilters()
    {
        $this->resultFilter = 'all';
        $this->engagementFilter = 'all';
        $this->searchTerm = '';
        $this->resetPage();
        $this->dispatch('testimonies-updated');
    }

    public function gotoPage($page, $pageName = 'page')
    {
        $this->setPage($page, $pageName);
        $this->dispatch('testimonies-updated');
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
        $query = Testimony::approved()
            ->where('publish_permission', true);

        if (!empty($this->searchTerm)) {
            $searchTerm = trim($this->searchTerm);
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%'.$searchTerm.'%')
                  ->orWhere('author', 'like', '%'.$searchTerm.'%')
                  ->orWhere('content', 'like', '%'.$searchTerm.'%');
            });
        }

        if ($this->resultFilter !== 'all' && !empty($this->resultFilter)) {
            $query->byCategory($this->resultFilter);
        }

        if ($this->engagementFilter !== 'all' && !empty($this->engagementFilter)) {
            $query->byEngagement($this->engagementFilter);
        }

        $testimonies = $query
            ->orderByDesc('reviewed_at')
            ->orderByDesc('created_at')
            ->paginate(9);

        return view('livewire.public.testimonies', [
            'testimonies' => $testimonies,
        ]);
    }
}
