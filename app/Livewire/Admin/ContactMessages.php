<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\ContactMessage;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class ContactMessages extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[Title('Contact Messages')]

    public $search = '';
    public $statusFilter = 'all'; // all, read, unread
    public $categoryFilter = 'all';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public $selectedMessage = null;
    public $showModal = false;
    public $showDeleteModal = false;
    public $messageToDelete = null;

    public function mount()
    {
        // Mark all messages as viewed when admin visits this page
        // This doesn't mark them as read, just that admin has seen the list
    }

    public function markAsRead($messageId)
    {
        $message = ContactMessage::findOrFail($messageId);

        if (!$message->is_read) {
            $message->markAsRead(auth()->user()->email);

            $this->dispatch('toastr-success', 'Message marked as read successfully.');
        }
    }

    public function markAsUnread($messageId)
    {
        $message = ContactMessage::findOrFail($messageId);

        $message->update([
            'is_read' => false,
            'read_by_email' => null,
            'read_at' => null
        ]);

        $this->dispatch('toastr-success', 'Message marked as unread successfully.');
    }

    public function viewMessage($messageId)
    {
        $this->selectedMessage = ContactMessage::findOrFail($messageId);
        $this->showModal = true;

        // Auto-mark as read when viewed
        if (!$this->selectedMessage->is_read) {
            $this->selectedMessage->markAsRead(auth()->user()->email);
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedMessage = null;
    }

    public function confirmDelete($messageId)
    {
        $this->messageToDelete = ContactMessage::findOrFail($messageId);
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->messageToDelete = null;
    }

    public function deleteMessage()
    {
        if ($this->messageToDelete) {
            $this->messageToDelete->delete();
            $this->dispatch('toastr-success', 'Message deleted successfully.');
            $this->cancelDelete();
        }
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatingSearch()
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

    public function getUnreadCountProperty()
    {
        return ContactMessage::unread()->count();
    }

    public function render()
    {
        $messages = ContactMessage::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('subject', 'like', '%' . $this->search . '%')
                      ->orWhere('message', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter === 'read', function ($query) {
                $query->where('is_read', true);
            })
            ->when($this->statusFilter === 'unread', function ($query) {
                $query->where('is_read', false);
            })
            ->when($this->categoryFilter !== 'all', function ($query) {
                $query->where('category', $this->categoryFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);

        $categories = ContactMessage::distinct()->pluck('category');

        return view('livewire.admin.contact-messages', [
            'messages' => $messages,
            'categories' => $categories,
        ]);
    }
}
