<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;
use App\Models\Event as EventModel;

#[Layout('layouts.admin')]
class Event extends Component
{
    use WithPagination;
    use WithFileUploads;

    public string $paginationTheme = 'bootstrap';

    public $showModal = false;
    public $isDeleteModalOpen = false;
    public $editMode = false;
    public $eventId;
    public $eventToDelete = null;

    // Form properties
    public $title = '';
    public $description = '';
    public $event_date = '';
    public $end_date = '';
    public $start_time = '';
    public $end_time = '';
    public $location = '';
    public $event_url = '';
    public $poster;
    public $current_poster; // To store current poster path for editing

    // Filters
    public $search = '';
    public $filterMonth = '';
    public $filterYear = '';

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'event_date' => 'required|date',
        'end_date' => 'nullable|date|after_or_equal:event_date',
        'start_time' => 'required',
        'end_time' => 'nullable',
        'location' => 'required|string|max:255',
        'event_url' => 'nullable|url|max:500',
        'poster' => 'nullable|image|mimes:png,jpeg,jpg|max:2048',
    ];

    protected $messages = [
        'title.required' => 'Please enter an event title.',
        'event_date.required' => 'Please select an event date.',
        'end_date.after_or_equal' => 'End date must be the same or after the start date.',
        'start_time.required' => 'Please select a start time.',
        'location.required' => 'Please enter a location.',
        'event_url.url' => 'Please enter a valid URL (e.g., https://zoom.us/j/123456789).',
        'poster.image' => 'The file must be an image.',
        'poster.mimes' => 'The poster must be a PNG or JPEG file.',
        'poster.max' => 'The poster size must not exceed 2MB.',
    ];

    /**
     * Shorten a URL using is.gd service
     */
    private function shortenUrl($url)
    {
        if (empty($url)) {
            return $url;
        }

        // Don't shorten already short URLs
        if (strlen($url) < 50) {
            return $url;
        }

        try {
            // Use is.gd free URL shortening service
            $context = stream_context_create([
                'http' => [
                    'timeout' => 10, // 10 seconds timeout
                    'method' => 'GET',
                ]
            ]);

            $shortUrl = file_get_contents(
                'https://is.gd/create.php?format=simple&url=' . urlencode($url),
                false,
                $context
            );

            // Check if shortening was successful
            if ($shortUrl && !str_starts_with($shortUrl, 'Error:') && filter_var($shortUrl, FILTER_VALIDATE_URL)) {
                return trim($shortUrl);
            }

            // If shortening fails, return original URL
            return $url;

        } catch (\Exception $e) {
            // If any error occurs, return original URL
            \Log::info('URL shortening failed: ' . $e->getMessage());
            return $url;
        }
    }

    protected function validateUniqueDateTime()
    {
        $query = EventModel::where('event_date', $this->event_date)
                           ->where('start_time', $this->start_time)
                           ->where('location', $this->location);

        // If editing, exclude the current event from the check
        if ($this->eventId) {
            $query->where('id', '!=', $this->eventId);
        }

        if ($query->exists()) {
            $this->addError('event_date', 'An event already exists for this date, time, and location.');
            return false;
        }

        return true;
    }

    public function create()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $event = EventModel::findOrFail($id);

        $this->eventId = $event->id;
        $this->title = $event->title;
        $this->description = $event->description;
        $this->event_date = $event->event_date->format('Y-m-d');
        $this->end_date = $event->end_date ? $event->end_date->format('Y-m-d') : '';
        $this->start_time = $event->start_time->format('H:i');
        $this->end_time = $event->end_time ? $event->end_time->format('H:i') : '';
        $this->location = $event->location;
        $this->event_url = $event->event_url;
        $this->current_poster = $event->poster;
        $this->poster = null; // Reset file upload

        $this->editMode = true;
        $this->showModal = true;
    }

    public function store()
    {
        // Validate the form data
        $this->validate();

        // Check for duplicate date/time/location combination
        if (!$this->validateUniqueDateTime()) {
            return;
        }

        if ($this->editMode) {
            $this->update();
        } else {
            // Handle file upload
            $posterPath = null;
            if ($this->poster) {
                $posterPath = $this->poster->store('posters', 'public');
            }

            // Shorten URL if provided
            $shortenedUrl = $this->event_url ? $this->shortenUrl($this->event_url) : null;

            // Create the event record
            EventModel::create([
                'title' => $this->title,
                'description' => $this->description,
                'event_date' => $this->event_date,
                'end_date' => $this->end_date ?: null,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time ?: null,
                'location' => $this->location,
                'event_url' => $shortenedUrl,
                'poster' => $posterPath,
                'created_by' => auth()->user()->email ?? 'Unknown',
            ]);

            $this->dispatch('toastr-success', 'Event created successfully.');
            $this->dispatch('event-created');
        }

        $this->closeModal();
        $this->resetForm();
    }

    public function update()
    {
        $event = EventModel::findOrFail($this->eventId);

        // Handle file upload for update
        $posterPath = $event->poster; // Keep existing poster by default

        if ($this->poster) {
            // Delete old poster if it exists
            if ($event->poster && Storage::disk('public')->exists($event->poster)) {
                Storage::disk('public')->delete($event->poster);
            }

            // Upload new poster
            $posterPath = $this->poster->store('posters', 'public');
        }

        // Shorten URL if it has changed
        $shortenedUrl = $this->event_url ? $this->shortenUrl($this->event_url) : null;

        // Update the event record
        $event->update([
            'title' => $this->title,
            'description' => $this->description,
            'event_date' => $this->event_date,
            'end_date' => $this->end_date ?: null,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time ?: null,
            'location' => $this->location,
            'event_url' => $shortenedUrl,
            'poster' => $posterPath,
            'created_by' => auth()->user()->email ?? $event->created_by, // Keep existing if no current user
        ]);

        $this->dispatch('toastr-success', 'Event updated successfully.');
        $this->dispatch('event-updated');
    }

    public function closeModal()
    {
        $this->showModal = false;
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

    private function resetForm()
    {
        $this->title = '';
        $this->description = '';
        $this->event_date = '';
        $this->end_date = '';
        $this->start_time = '';
        $this->end_time = '';
        $this->location = '';
        $this->event_url = '';
        $this->poster = null;
        $this->current_poster = null;
        $this->eventId = null;
        $this->resetValidation();
    }

    public function confirmDelete($id)
    {
        $this->eventToDelete = EventModel::findOrFail($id);
        $this->isDeleteModalOpen = true;
    }

    public function closeDeleteModal()
    {
        $this->isDeleteModalOpen = false;
        $this->eventToDelete = null;
    }

    public function delete()
    {
        try {
            if (!$this->eventToDelete) {
                $this->dispatch('toastr-error', 'No event selected for deletion.');
                return;
            }

            // Delete the poster file if it exists
            if ($this->eventToDelete->poster && Storage::disk('public')->exists($this->eventToDelete->poster)) {
                Storage::disk('public')->delete($this->eventToDelete->poster);
            }

            $this->eventToDelete->delete();
            $this->dispatch('toastr-success', 'Event deleted successfully!');
            $this->dispatch('event-deleted');

            // Close the modal and reset
            $this->closeDeleteModal();
        } catch (\Exception $e) {
            $this->dispatch('toastr-error', 'Failed to delete event: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $query = EventModel::query();

        // Apply search filter
        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%'.$this->search.'%')
                  ->orWhere('location', 'like', '%'.$this->search.'%');
            });
        }

        // Apply month filter
        if ($this->filterMonth) {
            $query->whereMonth('event_date', $this->filterMonth);
        }

        // Apply year filter
        if ($this->filterYear) {
            $query->whereYear('event_date', $this->filterYear);
        }

        $events = $query->latest('event_date')->orderBy('start_time', 'asc')->paginate(1);

        return view('livewire.admin.event', ['events' => $events]);
    }
}
