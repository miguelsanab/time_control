<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class WorkSession extends Model
{
    protected $fillable = [
        'user_id',
        'start_time',
        'end_time',
        'total_hours',
        'launch_taken',
        'description'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
}