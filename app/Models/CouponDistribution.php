<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CouponDistribution extends Model
{
    protected $fillable = [
        'user_id',
        'coupon_id',
        'confidence',
        'sent_at',
        'used_at',
        'model_metadata',
        'model_version',
        'revenue_impact'
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'used_at' => 'datetime',
        'model_metadata' => 'array',
        'revenue_impact' => 'decimal:2',
        'confidence' => 'decimal:2'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }
public static function conversionRate()
{
    $used = self::whereNotNull('used_at')->count();
    $total = self::count();
    
    return $total > 0 
        ? round(($used / $total) * 100, 1)
        : 0;
}
    // Scope pour le taux de conversion
    public function scopeConversionRate($query)
    {
        $used = $query->whereNotNull('used_at')->count();
        $total = $query->count();
        
        return $total ? round(($used / $total) * 100, 1) : 0;
    }
}