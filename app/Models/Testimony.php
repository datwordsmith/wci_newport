<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class Testimony extends Model
{
    protected $fillable = [
        'title',
        'author',
        'email',
        'phone',
        'result_category',
        'testimony_date',
        'engagements',
        'content',
        'publish_permission',
        'is_approved',
        'approved_at',
        'approved_by_email'
    ];

    protected $casts = [
        'engagements' => 'array',
        'publish_permission' => 'boolean',
        'is_approved' => 'boolean',
        'testimony_date' => 'date',
        'approved_at' => 'datetime'
    ];

    // Scopes for filtering
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('result_category', $category);
    }

    public function scopeByEngagement($query, $engagement)
    {
        return $query->whereJsonContains('engagements', $engagement);
    }

    public function scopeByEngagements($query, $engagements)
    {
        if (is_array($engagements) && !empty($engagements)) {
            return $query->where(function($q) use ($engagements) {
                foreach ($engagements as $engagement) {
                    $q->orWhereJsonContains('engagements', $engagement);
                }
            });
        }
        return $query;
    }

    // Accessor for formatted testimony date
    protected function formattedTestimonyDate(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->testimony_date ? Carbon::parse($this->testimony_date)->format('F j, Y') : null,
        );
    }

    // Accessor for engagements as comma-separated string
    protected function engagementsText(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->engagements ? implode(', ', $this->engagements) : '',
        );
    }

    // Method to approve testimony
    public function approve($adminEmail)
    {
        $this->update([
            'is_approved' => true,
            'approved_at' => now(),
            'approved_by_email' => $adminEmail
        ]);
    }

    // Method to unapprove testimony
    public function unapprove()
    {
        $this->update([
            'is_approved' => false,
            'approved_at' => null,
            'approved_by_email' => null
        ]);
    }
}
