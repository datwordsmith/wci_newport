<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Models\Wsf as WsfModel;
use Livewire\Attributes\Layout;

#[Layout('layouts.main')]
class Wsf extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'bootstrap';

    #[Title('Winners Satellite Fellowship')]
    public $description = "Bringing Jesus to your doorstep through fellowship and prayer";

protected $listeners = ['search-updated' => 'handleSearchUpdate'];

public function handleSearchUpdate($data)
{
    $this->search = $data['search'];
    \Log::info('Manual search update: ' . $this->search);
}

    public function updatingSearch($value)
    {
        \Log::info('updatingSearch called with: ' . $value);
        $this->resetPage();
    }

    public function updatedSearch()
    {
        \Log::info('updatedSearch called with: ' . $this->search);
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->resetPage();
    }

    // Add this method to test if the component is properly wired
    public function testSearch()
    {
        $this->search = 'test';
        \Log::info('testSearch called, search set to: ' . $this->search);
        $this->resetPage();
    }

    public function render()
    {
        \Log::info('Render called - Search term: "' . $this->search . '"');

        $query = WsfModel::query();

        // Apply search filter
        if (!empty($this->search)) {
            $searchTerm = trim($this->search);
            \Log::info('Applying search filter with term: "' . $searchTerm . '"');

            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%'.$searchTerm.'%')
                  ->orWhere('address', 'like', '%'.$searchTerm.'%')
                  ->orWhere('postcode', 'like', '%'.$searchTerm.'%')
                  ->orWhere('area', 'like', '%'.$searchTerm.'%');
            });
        }

        $wsfs = $query->orderBy('name', 'asc')->paginate(9);

        \Log::info('Number of results: ' . $wsfs->count());
        \Log::info('Total results before pagination: ' . $wsfs->total());

        return view('livewire.public.wsf', [
            'wsfs' => $wsfs
        ]);
    }
}
