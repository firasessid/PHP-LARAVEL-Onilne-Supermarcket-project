<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Coupon;
use App\Models\UserBehavior;
use App\Models\CouponDistribution;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class CompleteDemoSeeder extends Seeder
{
    private $segments = ['VIP', 'Fidèle', 'Nouveau', 'Occasionnel', 'Premium'];

    public function run()
    {
        // 1. Création de 50 utilisateurs avec données réalistes
        $users = User::factory(50)->create()->each(function ($user) {
            $user->update([
                'segment' => $this->segments[array_rand($this->segments)],
                'loyalty_points' => rand(500, 10000),
                'age' => rand(18, 65),
                'purchase_frequency' => rand(1, 30) / 10,
                'avg_spending' => rand(100, 2000),
                'phone' => '06' . rand(10000000, 99999999),
                'active_status' => rand(0, 1),
                'created_at' => Carbon::now()->subDays(rand(1, 90))
            ]);
        });

        // 2. Création de 10 coupons variés
        $coupons = [
            $this->createCoupon('VIPEARLY', 'VIP Early Access', 'VIP', 'percent', 30, 1000),
            $this->createCoupon('FIDELITE25', 'Fidélité 25€', 'Fidèle', 'fixed', 25, 500),
            $this->createCoupon('BIENVENUE', 'Offre Bienvenue', 'Nouveau', 'percent', 20, 0),
            $this->createCoupon('FLASH10', 'Promo Flash', 'Occasionnel', 'fixed', 10, 200),
            $this->createCoupon('PREMIUM50', 'Premium Exclusive', 'Premium', 'percent', 50, 2000),
            $this->createCoupon('ETE2024', 'Été 2024', 'VIP', 'fixed', 40, 800),
            $this->createCoupon('SOLDES20', 'Soldes Hiver', 'Occasionnel', 'percent', 20, 100),
            $this->createCoupon('FAMILLE', 'Offre Famille', 'Fidèle', 'fixed', 30, 600),
            $this->createCoupon('NOUVEAU15', 'Nouveau Client', 'Nouveau', 'fixed', 15, 0),
            $this->createCoupon('ANNIVERSAIRE', 'Cadeau Anniversaire', 'VIP', 'percent', 25, 500)
        ];

        // 3. Distribution massive des coupons
        foreach ($users as $user) {
            $eligibleCoupons = Coupon::where('target_segment', $user->segment)
                ->where('status', 1)
                ->where('starts_at', '<=', now())
                ->where('expires_at', '>=', now())
                ->get();

            foreach ($eligibleCoupons as $coupon) {
                $this->distributeCoupon($user, $coupon);
            }
        }

        // 4. Génération des comportements utilisateurs
        User::all()->each(function ($user) {
            UserBehavior::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'engagement_score' => $this->calculateEngagement($user),
                    'preferences' => $this->generatePreferences(),
                    'interaction_history' => $this->generateInteractionHistory()
                ]
            );
        });
    }

    private function createCoupon($code, $name, $segment, $type, $amount, $points)
    {
        return Coupon::firstOrCreate(
            ['code' => $code],
            [
                'name' => $name,
                'max_uses' => 1000,
                'max_uses_user' => ($type === 'percent') ? 2 : 1,
                'type' => $type,
                'discount_amount' => $amount,
                'min_amount' => ($type === 'percent') ? 50 : 20,
                'status' => 1,
                'target_segment' => $segment,
                'points_required' => $points,
                'starts_at' => now()->subDays(rand(1, 30)),
                'expires_at' => now()->addDays(rand(15, 60))
            ]
        );
    }

    private function distributeCoupon($user, $coupon)
    {
        $usedAt = rand(0, 10) > 3 ? now()->subDays(rand(1, 14)) : null;

        CouponDistribution::updateOrCreate(
            ['user_id' => $user->id, 'coupon_id' => $coupon->id],
            [
                'confidence' => rand(7000, 9500) / 100,
                'sent_at' => now()->subDays(rand(1, 30)),
                'used_at' => $usedAt,
                'revenue_impact' => $usedAt ? $this->calculateRevenueImpact($coupon) : null,
                'model_version' => '2.0.0',
                'model_metadata' => ['algorithm' => 'random_forest']
            ]
        );
    }

    private function calculateRevenueImpact($coupon)
    {
        if ($coupon->type === 'percent') {
            return rand(5000, 30000) / 100;
        }
        return $coupon->discount_amount * rand(1, 5);
    }

    private function calculateEngagement($user)
    {
        $base = rand(20, 80) / 10;
        $activityBonus = $user->purchase_frequency * 0.2;
        $loyaltyBonus = $user->loyalty_points / 1000 * 0.5;
        return min(10, $base + $activityBonus + $loyaltyBonus);
    }

    private function generatePreferences()
    {
        $categories = [
            ['Électronique', 'Mode', 'Maison'],
            ['Alimentation', 'Cosmétiques', 'Sport'],
            ['Voyages', 'Loisirs', 'Culture']
        ];
        return ['categories' => $categories[array_rand($categories)]];
    }

    private function generateInteractionHistory()
    {
        return [
            'logins' => rand(5, 50),
            'page_views' => rand(20, 300),
            'last_active' => now()->subHours(rand(1, 72))->toDateTimeString()
        ];
    }
}