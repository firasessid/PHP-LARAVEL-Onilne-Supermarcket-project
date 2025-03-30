<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    protected $fillable = [
        'user_id',
        'ip_address',
        'device_type',
        'browser',
        'location',
        'login_time',
        'action_type',
        'metadata',
        'risk_score'
    ];

    protected $casts = [
        'login_time' => 'datetime',
        'metadata' => 'array'
    ];
}