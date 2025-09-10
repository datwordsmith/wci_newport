<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'category',
        'message',
        'is_read',
        'read_by_email',
        'read_at'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    // Scope for unread messages
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    // Mark message as read by an admin
    public function markAsRead($adminEmail)
    {
        $this->update([
            'is_read' => true,
            'read_by_email' => $adminEmail,
            'read_at' => now()
        ]);
    }
}
