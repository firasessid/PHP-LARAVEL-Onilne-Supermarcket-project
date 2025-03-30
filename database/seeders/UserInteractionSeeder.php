<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserInteraction;
use Illuminate\Support\Facades\DB;

class UserInteractionSeeder extends Seeder
{
    public function run()
    {
        // Tronquer la table avant d'insérer de nouvelles données (facultatif)
        DB::table('user_interactions')->truncate();

        // Récupérer les IDs des utilisateurs et des produits existants
        $userIds = \App\Models\User::pluck('id')->toArray(); // IDs des utilisateurs existants
        $productIds = \App\Models\Product::pluck('id')->toArray(); // IDs des produits existants

        if (empty($userIds) || empty($productIds)) {
            $this->command->error('Aucun utilisateur ou produit trouvé. Veuillez vérifier que les tables users et products contiennent des données.');
            return;
        }

        // Tableau de types d'actions avec leurs scores associés
        $actionTypes = [
            'view' => 1,
            'click' => 2,
            'add_to_cart' => 3,
            'purchase' => 5,
        ];

        // Générer des interactions pour plusieurs utilisateurs et produits
        $interactions = [];
        foreach ($userIds as $userId) {
            foreach ($productIds as $productId) {
                // Choisir aléatoirement un type d'action
                $randomAction = array_rand($actionTypes);
                $actionType = $randomAction;
                $interactionScore = $actionTypes[$randomAction];

                // Ajouter l'interaction au tableau
                $interactions[] = [
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'action_type' => $actionType,
                    'interaction_score' => $interactionScore,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Insérer les données par lots de 100
                if (count($interactions) >= 100) {
                    UserInteraction::insert($interactions);
                    $interactions = []; // Réinitialiser le tableau
                }
            }
        }

        // Insérer les interactions restantes (si elles existent)
        if (!empty($interactions)) {
            UserInteraction::insert($interactions);
        }

        $this->command->info('Données d\'interaction simulées insérées avec succès.');
    }
}