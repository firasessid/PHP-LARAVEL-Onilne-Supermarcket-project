<?php

namespace App\Models;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\UserBehavior;
use App\Models\CouponDistribution;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'active_status',
        'avatar',
        'phone',
        'address',
        'google2fa_secret',
        'loyalty_points',
        'segment',
        'age',
        'purchase_frequency',
        'avg_spending'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google2fa_secret'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'active_status' => 'boolean',
        'loyalty_points' => 'integer',
        'age' => 'integer',
        'purchase_frequency' => 'decimal:2',
        'avg_spending' => 'decimal:2'
    ];
   // Dans app/Models/User.php
public function calculateSegment(): string
{
    $segments = Coupon::query()
        ->active()
        ->select('target_segment')
        ->selectRaw('MIN(points_required) as min_points')
        ->groupBy('target_segment')
        ->orderByDesc('min_points')
        ->get();

    foreach ($segments as $segment) {
        if ($this->loyalty_points >= $segment->min_points) {
            return $segment->target_segment;
        }
    }

    return 'regular';
}

public function updatePurchaseStats(float $orderTotal): void
{
    $this->purchase_frequency++;
    $this->loyalty_points += $orderTotal / 10;
    $this->avg_spending = ($this->avg_spending * ($this->purchase_frequency - 1) + $orderTotal) / $this->purchase_frequency;
    $this->segment = $this->calculateSegment();
    $this->save();
}
  
    public function behavior()
    {
        return $this->hasOne(UserBehavior::class);
    }

    public function couponDistributions()
    {
        return $this->hasMany(CouponDistribution::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function getAvgEngagementAttribute()
    {
        return $this->behavior?->engagement_score;
    }
}
