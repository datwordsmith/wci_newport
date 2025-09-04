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
    }

    public function updatingSearch($value)
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = WsfModel::query();

        // Apply search filter
        if (!empty($this->search)) {
            $searchTerm = trim($this->search);

            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%'.$searchTerm.'%')
                  ->orWhere('address', 'like', '%'.$searchTerm.'%')
                  ->orWhere('postcode', 'like', '%'.$searchTerm.'%')
                  ->orWhere('area', 'like', '%'.$searchTerm.'%');
            });
        }

        $wsfs = $query->orderBy('name', 'asc')->paginate(9);

        return view('livewire.public.wsf', [
            'wsfs' => $wsfs
        ]);
    }
}
