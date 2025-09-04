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
        'status',
        'admin_feedback',
        'reviewed_at',
        'approved_by_email'
    ];

    protected $casts = [
        'engagements' => 'array',
        'publish_permission' => 'boolean',
        'testimony_date' => 'date',
        'reviewed_at' => 'datetime'
    ];

    // Scopes for filtering
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeDeclined($query)
    {
        return $query->where('status', 'declined');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
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
            'status' => 'approved',
            'reviewed_at' => now(),
            'approved_by_email' => $adminEmail,
            'admin_feedback' => null // Clear any previous feedback
        ]);
    }

    // Method to decline testimony with feedback
    public function decline($adminEmail, $feedback = null)
    {
        $this->update([
            'status' => 'declined',
            'reviewed_at' => now(),
            'approved_by_email' => $adminEmail,
            'admin_feedback' => $feedback
        ]);
    }

    // Method to reset to pending status
    public function resetToPending()
    {
        $this->update([
            'status' => 'pending',
            'reviewed_at' => null,
            'approved_by_email' => null,
            'admin_feedback' => null
        ]);
    }

    // Helper methods for status checking
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isDeclined()
    {
        return $this->status === 'declined';
    }
}
