<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\NewsUpdate;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.admin')]
#[Title('News & Updates')]
class NewsUpdates extends Component
{
    use WithPagination;

    public string $paginationTheme = 'bootstrap';

    public string $search = '';
    public string $statusFilter = 'all';
    public string $is_featured_filter = 'all';

    public bool $showDeleteModal = false;
    public ?NewsUpdate $newsToDelete = null;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatingIsFeaturedFilter(): void
    {
        $this->resetPage();
    }

    public function confirmDelete(int $id): void
    {
        $this->newsToDelete = NewsUpdate::findOrFail($id);
        $this->showDeleteModal = true;
    }

    public function cancelDelete(): void
    {
        $this->showDeleteModal = false;
        $this->newsToDelete = null;
    }

    public function delete(): void
    {
        if (! $this->newsToDelete) {
            return;
        }

        if ($this->newsToDelete->attachment_path
            && Storage::disk('public')->exists($this->newsToDelete->attachment_path)) {
            Storage::disk('public')->delete($this->newsToDelete->attachment_path);
        }

        $this->newsToDelete->delete();
        $this->dispatch('toastr-success', 'News item deleted successfully.');
        $this->cancelDelete();
    }

    public function render()
    {
        $newsItems = NewsUpdate::query()
            ->when($this->search, function ($q) {
                $q->where(function ($inner) {
                    $inner->where('title', 'like', '%' . $this->search . '%')
                          ->orWhere('excerpt', 'like', '%' . $this->search . '%')
                          ->orWhere('body', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter !== 'all', fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->is_featured_filter === 'featured', fn ($q) => $q->where('is_featured', true))
            ->when($this->is_featured_filter === 'regular', fn ($q) => $q->where('is_featured', false))
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.admin.news-updates', compact('newsItems'));
    }
}
