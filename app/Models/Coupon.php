<?php

namespace App\Models;
use App\Models\CouponDistribution;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'name',
        'max_uses',
        'max_uses_user',
        'type',
        'discount_amount',
        'min_amount',
        'status',
        'target_segment',
        'points_required',
        'starts_at',
        'expires_at'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'status' => 'boolean',
    ];

    public function distributions(): HasMany
    {
        return $this->hasMany(CouponDistribution::class);
    }

    // Accessors pour l'interface
    public function getStatusLabelAttribute(): string
    {
        return $this->status ? 'Actif' : 'Inactif';
    }

    public function getStatusClassAttribute(): string
    {
        return $this->status ? 'success' : 'secondary';
    }
    // Dans app/Models/Coupon.php
public function scopeActive($query)
{
    return $query->where('status', 1)
        ->where('expires_at', '>', now());
}
public function getId(): int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}