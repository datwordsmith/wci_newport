<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestimonyImage extends Model
{
    protected $fillable = [
        'testimony_id',
        'image',
        'caption',
        'sort_order',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get the testimony that owns the image.
     */
    public function testimony(): BelongsTo
    {
        return $this->belongsTo(Testimony::class);
    }

    /**
     * Get the full image URL.
     */
    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image);
    }

    /**
     * Scope to get only approved images.
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope to order by sort order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
