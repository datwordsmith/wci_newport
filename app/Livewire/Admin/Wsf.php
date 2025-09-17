<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\Wsf as WsfModel;

#[Layout('layouts.admin')]
class Wsf extends Component
{
    use WithPagination;

    #[Title('Winners Satellite Fellowship')]
    public string $paginationTheme = 'bootstrap';

    public $showModal = false;
    public $isDeleteModalOpen = false;
    public $editMode = false;
    public $wsfId;
    public $wsfToDelete = null;

    // Form properties
    public $name;
    public $address;
    public $postcode;
    public $area;

    public $search = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:1000',
        'postcode' => 'required|string|max:10',
        'area' => 'required|string|max:50',
    ];

    protected $messages = [
        'name.required' => 'Please enter the WSF name.',
        'address.required' => 'Please enter the WSF address.',
        'postcode.required' => 'Please enter the WSF postcode.',
        'area.required' => 'Please enter the WSF area.',
    ];

    public function create()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function store()
    {
        // Validate the form data
        $this->validate();

        if ($this->editMode) {
            $this->update();
        } else {
            // Create the WSF record
            WsfModel::create([
                'name' => $this->name,
                'address' => $this->address,
                'postcode' => $this->postcode,
                'area' => $this->area,
                'created_by' => auth()->user()->email ?? 'Unknown',
            ]);
            $this->dispatch('toastr-success', 'WSF created successfully.');
            $this->dispatch('wsf-created');
        }

        $this->closeModal();
        $this->resetForm();
    }

    public function edit($id)
    {
        $wsf = WsfModel::findOrFail($id);

        $this->wsfId = $wsf->id;
        $this->name = $wsf->name;
        $this->address = $wsf->address;
        $this->postcode = $wsf->postcode;
        $this->area = $wsf->area;

        $this->editMode = true;
        $this->showModal = true;
    }

    public function update()
    {
        $wsf = WsfModel::findOrFail($this->wsfId);

        // Update the WSF record
        $wsf->update([
            'name' => $this->name,
            'address' => $this->address,
            'postcode' => $this->postcode,
            'area' => $this->area,
            'created_by' => auth()->user()->email ?? $wsf->created_by, // Keep existing if no current user
        ]);

        $this->dispatch('toastr-success', 'WSF updated successfully.');
        $this->dispatch('wsf-updated');
    }

    public function delete()
    {
        try {
            if (!$this->wsfToDelete) {
                $this->dispatch('toastr-error', 'No WSF  selected for deletion.');
                return;
            }

            $this->wsfToDelete->delete();
            $this->dispatch('toastr-success', 'WSF deleted successfully!');
            $this->dispatch('wsf-deleted');

            // Close the modal and reset
            $this->closeDeleteModal();
        } catch (\Exception $e) {
            $this->dispatch('toastr-error', 'Failed to delete WSF: ' . $e->getMessage());
        }
    }

    private function resetForm()
    {
        $this->name = '';
        $this->address = '';
        $this->postcode = '';
        $this->area = '';
        $this->resetValidation();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->filterMonth = '';
        $this->filterYear = '';
        $this->resetPage();
    }


    public function confirmDelete($id)
    {
        $this->wsfToDelete = WsfModel::findOrFail($id);
        $this->isDeleteModalOpen = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetValidation(); // Clear validation errors
    }

    public function closeDeleteModal()
    {
        $this->isDeleteModalOpen = false;
        $this->wsfToDelete = null;
    }

    public function render()
    {
        $query = WsfModel::query();

        // Apply search filter
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('address', 'like', '%'.$this->search.'%')
                  ->orWhere('postcode', 'like', '%'.$this->search.'%')
                  ->orWhere('area', 'like', '%'.$this->search.'%');
            });
        }

        $wsfs = $query->orderBy('name', 'asc')->paginate(9);

        return view('livewire.admin.wsf', compact('wsfs'));
    }
}
