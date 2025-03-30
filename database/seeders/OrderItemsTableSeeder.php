<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class OrderItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get all order IDs from the database
        $orderIds = DB::table('orders')->pluck('id')->toArray();

        // Get all valid product IDs from the products table
        $productIds = DB::table('products')->pluck('id')->toArray();

        // Ensure there are products available to associate with order items
        if (empty($productIds)) {
            echo "No products found. Please ensure the 'products' table has data.";
            return;
        }

        // Insert multiple items for each order
        foreach ($orderIds as $orderId) {
            foreach (range(1, $faker->numberBetween(1, 5)) as $index) { // Each order can have 1 to 5 items
                $productId = $faker->randomElement($productIds); // Pick a valid product ID from the products table
                $qty = $faker->numberBetween(1, 10);
                $price = $faker->randomFloat(2, 10, 500); // Price per unit

                DB::table('order_items')->insert([
                    'order_id' => $orderId,
                    'product_id' => $productId,
                    'name' => "Product $productId",
                    'qty' => $qty,
                    'price' => $price,
                    'total' => $price * $qty,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
