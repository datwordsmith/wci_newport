<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'end_date',
        'start_time',
        'end_time',
        'location',
        'event_url',
        'poster',
        'created_by',
        // Recurrence
        'repeat_monthly',
        'repeat_week_of_month',
        'repeat_day_of_week',
        'repeat_until',
        'parent_event_id',
    ];

    protected $casts = [
        'event_date' => 'datetime:M d, Y',
        'end_date' => 'datetime:M d, Y',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'repeat_monthly' => 'boolean',
        'repeat_until' => 'date',
    ];

    public function getSlugAttribute()
    {
        return str()->slug($this->title);
    }

    /**
     * Get the formatted event date
     */
    public function getFormattedDate(): string
    {
        if ($this->end_date && $this->event_date->format('Y-m-d') !== $this->end_date->format('Y-m-d')) {
            return $this->event_date->format('M d') . ' - ' . $this->end_date->format('M d, Y');
        }

        return $this->event_date->format('M d, Y');
    }

    /**
     * Get the formatted date range
     */
    public function getDateRange(): string
    {
        if ($this->end_date && $this->event_date->format('Y-m-d') !== $this->end_date->format('Y-m-d')) {
            return $this->event_date->format('M d, Y') . ' - ' . $this->end_date->format('M d, Y');
        }

        return $this->event_date->format('M d, Y');
    }

    /**
     * Get the formatted time range
     */
    public function getTimeRange(): string
    {
        $start = $this->start_time->format('g:i A');

        if ($this->end_time) {
            $end = $this->end_time->format('g:i A');
            return "{$start} - {$end}";
        }

        return $start;
    }

    /**
     * Scope for upcoming events
     */
    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now()->toDateString());
    }

    /**
     * Get upcoming events with only next occurrence of recurring series
     */
    public static function getUpcomingUniqueRecurring()
    {
        $today = now()->toDateString();

        // Get all upcoming events
        $allEvents = static::where('event_date', '>=', $today)
            ->orderBy('event_date')
            ->orderBy('start_time')
            ->get();

        // Filter to show only the next occurrence of each recurring series
        $filteredEvents = collect();
        $seenRecurringSeries = [];

        foreach ($allEvents as $event) {
            if ($event->isRecurringInstance()) {
                // For recurring instances, only show the first one we encounter per parent
                $parentId = $event->parent_event_id;
                if (!in_array($parentId, $seenRecurringSeries)) {
                    $filteredEvents->push($event);
                    $seenRecurringSeries[] = $parentId;
                }
            } elseif ($event->isRecurringMaster()) {
                // For recurring masters, check if we have any upcoming instances
                $nextInstance = static::where('parent_event_id', $event->id)
                    ->where('event_date', '>=', $today)
                    ->orderBy('event_date')
                    ->orderBy('start_time')
                    ->first();

                if ($nextInstance) {
                    // Show the next instance instead of the master
                    if (!in_array($event->id, $seenRecurringSeries)) {
                        $filteredEvents->push($nextInstance);
                        $seenRecurringSeries[] = $event->id;
                    }
                } else {
                    // No upcoming instances, show the master if it's upcoming
                    if ($event->event_date >= $today) {
                        $filteredEvents->push($event);
                    }
                }
            } else {
                // Regular non-recurring events
                $filteredEvents->push($event);
            }
        }

        return $filteredEvents;
    }

    /**
     * Check if this event is the master recurring event
     */
    public function isRecurringMaster(): bool
    {
        return $this->repeat_monthly === true;
    }

    /**
     * Check if this event is part of a recurring series (generated from master)
     */
    public function isRecurringInstance(): bool
    {
        return !is_null($this->parent_event_id);
    }

    /**
     * Check if this event is related to recurrence (either master or instance)
     */
    public function isRecurring(): bool
    {
        return $this->isRecurringMaster() || $this->isRecurringInstance();
    }

    /**
     * Get the recurring event description for display
     */
    public function getRecurringDescription(): string
    {
        if ($this->isRecurringMaster()) {
            $weekNames = ['', 'First', 'Second', 'Third', 'Fourth', 'Fifth'];
            $dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

            $weekText = $this->repeat_week_of_month == -1 ? 'Last' : $weekNames[$this->repeat_week_of_month];
            $dayText = $dayNames[$this->repeat_day_of_week];

            return "Repeats every {$weekText} {$dayText} of the month";
        }

        if ($this->isRecurringInstance()) {
            return "Part of recurring series";
        }

        return '';
    }

    /**
     * Get the parent event if this is a recurring instance
     */
    public function parentEvent()
    {
        return $this->belongsTo(Event::class, 'parent_event_id');
    }

    /**
     * Get all child events if this is a recurring master
     */
    public function childEvents()
    {
        return $this->hasMany(Event::class, 'parent_event_id');
    }
}
