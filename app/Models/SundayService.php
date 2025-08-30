<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SundayService extends Model
{
    protected $fillable = [
        'sunday_theme',
        'sunday_poster',
        'service_date',
        'service_time',
        'user_email',
    ];
}
