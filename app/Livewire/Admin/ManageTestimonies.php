<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\Testimony;
use Illuminate\Support\Facades\Mail;

#[Layout('layouts.admin')]
class ManageTestimonies extends Component
{
    use WithPagination;

    #[Title('Manage Testimonies')]

    // Filters
    public $statusFilter = 'all';
    public $categoryFilter = 'all';
    public $engagementFilter = 'all';
    public $searchTerm = '';

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        // You can add any initialization logic here
    }

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatingEngagementFilter()
    {
        $this->resetPage();
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
        $testimonies = Testimony::query()
            ->when($this->statusFilter !== 'all', function($query) {
                $query->byStatus($this->statusFilter);
            })
            ->when($this->categoryFilter !== 'all', function($query) {
                $query->byCategory($this->categoryFilter);
            })
            ->when($this->engagementFilter !== 'all', function($query) {
                $query->byEngagement($this->engagementFilter);
            })
            ->when($this->searchTerm, function($query) {
                $query->where(function($q) {
                    $q->where('title', 'like', '%' . $this->searchTerm . '%')
                      ->orWhere('author', 'like', '%' . $this->searchTerm . '%')
                      ->orWhere('content', 'like', '%' . $this->searchTerm . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.manage-testimonies', [
            'testimonies' => $testimonies
        ]);
    }
}
