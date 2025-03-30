<?php
namespace App\Services;

use App\Models\{User, Coupon, CouponDistribution};
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\{Process, Exception\ProcessFailedException};

class CouponDistributionService
{
    public function __construct(
        protected SmsService $smsService
    ) {}

   // Dans CouponDistributionService.php
   private function selectBestCoupon(User $user, \Illuminate\Support\Collection $coupons): array
   {
       $defaultConfidence = 0.75; // Valeur par défaut si le script échoue
   
       try {
           $process = new Process([
               'python3',
               base_path('scripts/coupon_predictor.py'),
               'predict',
               base64_encode(json_encode($this->getUserFeatures($user)))
           ]);
   
           $process->mustRun();
           $prediction = json_decode($process->getOutput(), true);
   
           return [
               'coupon' => $coupons->firstWhere('id', $prediction['coupon_id']),
               'confidence' => $prediction['confidence'] ?? $defaultConfidence
           ];
   
       } catch (ProcessFailedException $e) {
           Log::error("Erreur prédiction: ".$e->getMessage());
           return [
               'coupon' => $coupons->sortByDesc('discount_amount')->first(),
               'confidence' => $defaultConfidence
           ];
       }
   }
   public function distributeCouponsForUser(User $user, ?float $orderAmount): ?Coupon
   {
       Log::info("Début de distribution pour l'utilisateur: {$user->id}");
   
       // Récupérer les coupons éligibles
       $coupons = $this->getEligibleCoupons($user, $orderAmount);
       Log::debug("Coupons éligibles : " . $coupons->pluck('id')->join(', '));
   
       if ($coupons->isEmpty()) {
           Log::warning("Aucun coupon éligible pour l'utilisateur: {$user->id}");
           return null;
       }
   
       // Appeler le script Python pour la prédiction
       $prediction = $this->getPredictedCoupon($user); // Modification ici
       $predictedCouponId = $prediction['coupon_id'] ?? 0;
       $confidence = $prediction['confidence'] ?? 0.0;
   
       Log::info("Coupon prédit : {$predictedCouponId}, Confiance: {$confidence}");
   
       // Trouver le coupon dans la base de données
       $coupon = Coupon::find($predictedCouponId);
       if (!$coupon) {
           Log::error("Coupon prédit {$predictedCouponId} non trouvé. Utilisation d'un fallback.");
           $coupon = $coupons->sortByDesc('discount_amount')->first();
       }
   
       // Enregistrer et envoyer le coupon
       Log::info("Coupon sélectionné : {$coupon->id}");
       $this->sendAndLogCoupon(
           $user, 
           $coupon, 
           $orderAmount,
           $confidence
       );
       return $coupon;
   }
   
   // Modification de la méthode pour retourner un tableau
   private function getPredictedCoupon(User $user): array
   {
       $features = [
           'segment' => $user->segment,
           'loyalty_points' => $user->loyalty_points,
           'purchase_frequency' => $user->purchase_frequency,
           'avg_spending' => $user->avg_spending,
           'age' => $user->age ?? 0 // Gestion de l'âge manquant
       ];
   
       $encodedData = base64_encode(json_encode($features));
       $command = "python app/scripts/coupon_predictor.py predict \"{$encodedData}\"";
       $output = shell_exec($command);
       
       return json_decode($output, true) ?? ['coupon_id' => 0, 'confidence' => 0.0];
   }
    private function getEligibleCoupons(User $user, ?float $orderAmount): \Illuminate\Support\Collection
    {
        return Coupon::query()
            ->active()
            ->where('target_segment', $user->segment)
            ->where('points_required', '<=', $user->loyalty_points)
            ->where(function($query) use ($orderAmount) {
                $query->whereNull('min_amount')
                      ->orWhere('min_amount', '<=', $orderAmount);
            })
            ->whereDoesntHave('distributions', fn($q) => $q->where('user_id', $user->id))
            ->get();
    }

   

    private function getUserFeatures(User $user): array
    {
        return [
            'segment' => $user->segment,
            'loyalty_points' => $user->loyalty_points,
            'purchase_frequency' => $user->purchase_frequency,
            'avg_spending' => $user->avg_spending,
            'age' => $user->age
        ];
    }

    // Dans CouponDistributionService.php
    private function sendAndLogCoupon(User $user, Coupon $coupon, ?float $orderAmount, float $confidence): void
    {
        // Envoi SMS
        $smsSent = $this->smsService->sendCouponNotification($user, $coupon);
    
        // Enregistrement dans la base avec tous les champs requis
        CouponDistribution::create([
            'user_id' => $user->id,
            'coupon_id' => $coupon->id,
            'confidence' => $confidence, // Champ obligatoire
            'sent_at' => now(), // Champ obligatoire
            'model_version' => 'v2.1', // Champ obligatoire
            'model_metadata' => [ // Nom exact du champ JSON
                'order_amount' => $orderAmount,
                'user_features' => $this->getUserFeatures($user),
                'sms_status' => $smsSent ? 'sent' : 'failed'
            ],
            'revenue_impact' => null // Optionnel mais explicitement défini
        ]);
    }
}