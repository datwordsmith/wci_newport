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
    ];

    protected $casts = [
        'event_date' => 'datetime:M d, Y',
        'end_date' => 'datetime:M d, Y',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
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
}
