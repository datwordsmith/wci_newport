<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\Event as EventModel;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

#[Layout('layouts.admin')]
class Event extends Component
{
    use WithPagination;
    use WithFileUploads;

    #[Title('Events')]

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

    // Recurrence (single-day monthly rule)
    public $repeat_monthly = false;            // bool
    public $repeat_week_of_month = null;       // 1..5
    public $repeat_day_of_week = null;         // 0=Sun .. 6=Sat
    public $repeat_until = null;               // Y-m-d

    // Filters
    public $search = '';
    public $filterMonth = '';
    public $filterYear = '';
    public $showUpcomingOnly = false;

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
    // Recurrence
    'repeat_monthly' => 'boolean',
            'repeat_week_of_month' => 'nullable|integer|min:-1|max:4',
    'repeat_day_of_week' => 'nullable|integer|min:0|max:6',
    'repeat_until' => 'nullable|date|after:event_date',
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

    // Recurrence
    $this->repeat_monthly = (bool)($event->repeat_monthly ?? false);
    $this->repeat_week_of_month = $event->repeat_week_of_month;
    $this->repeat_day_of_week = $event->repeat_day_of_week;
    $this->repeat_until = $event->repeat_until ? Carbon::parse($event->repeat_until)->format('Y-m-d') : null;

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

            // Create the base event record
            $base = EventModel::create([
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
                // Recurrence settings
                'repeat_monthly' => (bool)$this->repeat_monthly,
                'repeat_week_of_month' => $this->repeat_week_of_month,
                'repeat_day_of_week' => $this->repeat_day_of_week,
                'repeat_until' => $this->repeat_until ?: null,
            ]);

            // Generate recurring instances when applicable
            if ($this->repeat_monthly && $this->repeat_week_of_month && $this->repeat_day_of_week && $this->repeat_until) {
                $this->generateMonthlyRecurringInstances($base);
            }

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
            // Recurrence settings
            'repeat_monthly' => (bool)$this->repeat_monthly,
            'repeat_week_of_month' => $this->repeat_week_of_month,
            'repeat_day_of_week' => $this->repeat_day_of_week,
            'repeat_until' => $this->repeat_until ?: null,
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
        $this->showUpcomingOnly = false;
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

    // Recurrence
    $this->repeat_monthly = false;
    $this->repeat_week_of_month = null;
    $this->repeat_day_of_week = null;
    $this->repeat_until = null;
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

    /**
     * Generate child events for a monthly recurring rule like "1st Saturday of every month".
     */
    private function generateMonthlyRecurringInstances(EventModel $base): void
    {
        $originalDate = Carbon::parse($base->event_date)->startOfDay();
        $until = Carbon::parse($this->repeat_until)->endOfDay();
        $today = Carbon::now()->startOfDay();

        // Start from the original event's month, but generate instances starting from today
        $cursor = $originalDate->copy()->startOfMonth();

        // If original event is in the past, start from current month
        if ($originalDate->lt($today)) {
            $cursor = $today->copy()->startOfMonth();
        }

        while ($cursor->lte($until)) {
            $target = $this->nthWeekdayOfMonth($cursor->copy(), (int)$this->repeat_week_of_month, (int)$this->repeat_day_of_week);

            if ($target && $target->betweenIncluded($cursor->startOfMonth(), $until)) {
                // Only create if the target date is today or in the future, and not the same as original event
                if ($target->gte($today) && !$target->isSameDay($originalDate)) {
                    EventModel::create([
                        'title' => $base->title,
                        'description' => $base->description,
                        'event_date' => $target->toDateString(),
                        'end_date' => null,
                        'start_time' => optional($base->start_time)->format('H:i'),
                        'end_time' => optional($base->end_time)->format('H:i'),
                        'location' => $base->location,
                        'event_url' => $base->event_url,
                        'poster' => $base->poster,
                        'created_by' => auth()->user()->email ?? $base->created_by,
                        'repeat_monthly' => false, // Child events are not themselves recurring
                        'repeat_week_of_month' => null,
                        'repeat_day_of_week' => null,
                        'repeat_until' => null,
                        'parent_event_id' => $base->id,
                    ]);
                }
            }
            $cursor->addMonth()->startOfMonth();
        }
    }

    /**
     * Find the Nth weekday in a month (week: 1..4 or -1 for last, weekday: 0=Sun..6=Sat)
     */
    private function nthWeekdayOfMonth(Carbon $monthStart, int $week, int $weekday): ?Carbon
    {
        $date = $monthStart->copy()->startOfMonth();

        if ($week === -1) {
            // Find last occurrence of weekday in the month
            $lastDay = $date->copy()->endOfMonth();
            $lastWeekday = $lastDay->copy()->previous($weekday);
            if ($lastDay->dayOfWeek === $weekday) {
                $lastWeekday = $lastDay->copy();
            }
            return $lastWeekday->month === $monthStart->month ? $lastWeekday : null;
        } else {
            // Find Nth occurrence (1st, 2nd, 3rd, 4th)
            $first = $date->copy()->next($weekday);
            if ($date->dayOfWeek === $weekday) {
                $first = $date->copy();
            }
            $target = $first->copy()->addWeeks($week - 1);
            return $target->month === $monthStart->month ? $target : null;
        }
    }

    /**
     * Regenerate recurring instances for an existing recurring event
     */
    public function regenerateRecurringInstances($eventId)
    {
        try {
            $event = EventModel::findOrFail($eventId);
            
            if (!$event->repeat_monthly) {
                $this->dispatch('toastr-error', 'This is not a recurring event.');
                return;
            }

            // Delete existing child events
            EventModel::where('parent_event_id', $event->id)->delete();

            // Set the recurrence properties temporarily for generation
            $this->repeat_monthly = $event->repeat_monthly;
            $this->repeat_week_of_month = $event->repeat_week_of_month;
            $this->repeat_day_of_week = $event->repeat_day_of_week;
            $this->repeat_until = $event->repeat_until;

            // Regenerate instances
            $this->generateMonthlyRecurringInstances($event);

            $this->dispatch('toastr-success', 'Recurring instances regenerated successfully.');
        } catch (\Exception $e) {
            $this->dispatch('toastr-error', 'Failed to regenerate instances: ' . $e->getMessage());
        }
    }

    /**
     * Duplicate an existing event (including poster) and open it for editing
     */
    public function duplicate($id)
    {
        try {
            $event = EventModel::findOrFail($id);

            // Copy poster if it exists
            $newPosterPath = null;
            if ($event->poster && Storage::disk('public')->exists($event->poster)) {
                $extension = pathinfo($event->poster, PATHINFO_EXTENSION);
                $filename = pathinfo($event->poster, PATHINFO_FILENAME);
                $newPosterPath = 'posters/' . $filename . '-copy-' . time() . '.' . $extension;
                Storage::disk('public')->copy($event->poster, $newPosterPath);
            }

            // Create duplicated event record
            $newEvent = EventModel::create([
                'title' => $event->title . ' (Copy)',
                'description' => $event->description,
                'event_date' => $event->event_date ? $event->event_date->format('Y-m-d') : null,
                'end_date' => $event->end_date ? $event->end_date->format('Y-m-d') : null,
                'start_time' => $event->start_time ? $event->start_time->format('H:i') : null,
                'end_time' => $event->end_time ? $event->end_time->format('H:i') : null,
                'location' => $event->location,
                'event_url' => $event->event_url,
                'poster' => $newPosterPath,
                'created_by' => auth()->user()->email ?? $event->created_by,
            ]);

            // Open the newly created event in edit mode
            $this->dispatch('toastr-success', 'Event duplicated. You can now edit it.');
            $this->edit($newEvent->id);
        } catch (\Exception $e) {
            $this->dispatch('toastr-error', 'Failed to duplicate event: ' . $e->getMessage());
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

        // Apply upcoming events filter
        if ($this->showUpcomingOnly) {
            $query->where('event_date', '>=', now()->toDateString());
        }

        // Apply month filter
        if ($this->filterMonth) {
            $query->whereMonth('event_date', $this->filterMonth);
        }

        // Apply year filter
        if ($this->filterYear) {
            $query->whereYear('event_date', $this->filterYear);
        }

        $events = $query->latest('event_date')->orderBy('start_time', 'asc')->paginate(9);

        return view('livewire.admin.event', ['events' => $events]);
    }
}
