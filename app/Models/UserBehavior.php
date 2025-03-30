<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBehavior extends Model
{
    protected $fillable = [
        'user_id',
        'engagement_score',
        'preferences',
        'interaction_history'
    ];

    protected $casts = [
        'preferences' => 'array',
        'interaction_history' => 'array',
        'engagement_score' => 'decimal:2'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}