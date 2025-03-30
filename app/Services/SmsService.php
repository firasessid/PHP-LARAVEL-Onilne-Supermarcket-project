<?php
namespace App\Services;

use App\Models\User;
use App\Models\Coupon;
use App\Models\CouponDistribution;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class SmsService
{
    protected Client $twilio;

    public function __construct()
    {
        $this->twilio = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
    }
// Dans SmsService.php
public function sendCouponNotification(User $user, Coupon $coupon): bool
{
    try {
        $phone = $this->formatPhoneNumber($user->phone);

        // Message professionnel en anglais
        $message = "SuperNet Supermarket - Congratulations!\n"
            . "You have received an exclusive coupon:\n"
            . "🔖 Code: {$coupon->code}\n"
            . "💳 Discount: {$coupon->discount_amount} {$coupon->type}\n"
            . "⏳ Valid until: {$coupon->expires_at->format('d/m/Y')}\n\n"
            . "Use it during your next purchase in-store or online.\n"
            . "Thank you for being part of the SuperNet family!\n\n"
            . "👉 Learn more: https://supernet.com/coupons";

        $this->twilio->messages->create(
            $phone,
            [
                'from' => config('services.twilio.phone'), // Utilisez le numéro configuré dans .env
                'body' => $message
            ]
        );

        return true;
    } catch (\Exception $e) {
        Log::error("Failed to send SMS: " . $e->getMessage());
        return false;
    }
}
private function formatPhoneNumber(string $phone): string
{
    // Nettoyer le numéro (supprimer tout sauf les chiffres)
    $cleaned = preg_replace('/\D/', '', $phone);
    
    // Cas 1: Déjà en format international (ex: +216... ou 00216...)
    if (str_starts_with($cleaned, '216')) {
        return '+' . $cleaned;
    } elseif (str_starts_with($cleaned, '00216')) {
        return '+216' . substr($cleaned, 5);
    }
    
    // Cas 2: Format local avec 0 (ex: 012345678)
    if (str_starts_with($cleaned, '0')) {
        $formatted = '+216' . substr($cleaned, 1);
    } 
    // Cas 3: Numéro sans indicatif (supposé local)
    else {
        $formatted = '+216' . $cleaned;
    }
    
    // Tronquer à 8 chiffres après +216 (format E.164 valide)
    return preg_replace('/^(\+216\d{8}).*$/', '$1', $formatted);
}
}