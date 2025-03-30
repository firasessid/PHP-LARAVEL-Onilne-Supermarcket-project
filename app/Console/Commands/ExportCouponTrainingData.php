<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CouponDistribution;
use Illuminate\Support\Facades\Storage;

class ExportCouponTrainingData extends Command
{
    protected $signature = 'export:coupon-data';
    protected $description = 'Export coupon training data to CSV';

    public function handle()
    {
        // Récupérer les données de la table coupon_distributions
        $data = CouponDistribution::with(['user', 'coupon'])
            ->whereNotNull('used_at') // Seulement les coupons utilisés
            ->get()
            ->map(function ($distribution) {
                return [
                    'loyalty_points' => $distribution->user->loyalty_points,
                    'purchase_frequency' => $distribution->user->purchase_frequency,
                    'avg_spending' => $distribution->user->avg_spending,
                    'age' => $distribution->user->age,
                    'coupon_id' => $distribution->coupon_id,
                ];
            });

        // Convertir en CSV
        $csvHeader = ['loyalty_points', 'purchase_frequency', 'avg_spending', 'age', 'coupon_id'];
        $csvContent = $data->toArray();
        array_unshift($csvContent, $csvHeader); // Ajouter l'en-tête

        // Sauvegarder dans un fichier
        $filePath = storage_path('data/coupon_training_data.csv');
        $file = fopen($filePath, 'w');
        foreach ($csvContent as $row) {
            fputcsv($file, $row);
        }
        fclose($file);

        $this->info("Données exportées vers : $filePath");
    }
}