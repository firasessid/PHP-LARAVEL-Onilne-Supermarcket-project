<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class UserInteractionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userMinId = 25;
        $userMaxId = 35;
        $productMinId = 15; // Minimum product ID
        $productMaxId = 177; // Maximum product ID

        $data = [];

        // Generate data for each product
        for ($productId = $productMinId; $productId <= $productMaxId; $productId++) {
            $viewCount = rand(20, 50); // Random number of views

            for ($i = 0; $i < $viewCount; $i++) {
                $data[] = [
                    'user_id' => rand($userMinId, $userMaxId), // User ID range
                    'product_id' => $productId, // Valid product ID
                    'cluster_id' => rand(1, 5), // Random cluster ID
                    'action_type' => 'view', // Default to "view"
                    'interaction_time' => Carbon::now()->subMinutes(rand(0, 10000)),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        // Insert data in chunks to avoid memory issues
        $chunks = array_chunk($data, 1000);
        foreach ($chunks as $chunk) {
            DB::table('user_interactions')->insert($chunk);
        }
    }
}
