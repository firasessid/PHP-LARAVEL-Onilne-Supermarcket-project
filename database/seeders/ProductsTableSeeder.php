<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Insert 50 sample products into the database
        foreach (range(1, 50) as $index) {
            DB::table('products')->insert([
                'name' => $faker->word,
                'slug' => $faker->slug,
                'status' => $faker->randomElement([0, 1]),
                'image' => $faker->imageUrl(),
                'short_description' => $faker->sentence,
                'description' => $faker->paragraph,
                'sale_price' => $faker->randomFloat(2, 10, 500),
                'regular_price' => $faker->randomFloat(2, 10, 500),
                'quantity' => $faker->numberBetween(1, 100),
                'ray_id' => 1,  // assuming you have a ray table with a ray_id of 1
                'category_id' => 1,  // assuming category_id is 1
                'sub_category_id' => 1,  // assuming sub_category_id is 1
                'brand_id' => 1,  // assuming you have a brand table with a brand_id of 1
                'sku' => $faker->unique()->word,
                'is_featured' => $faker->randomElement(['Yes', 'No']),
                'is_approved' => 1,  // Set is_approved to true by default
                'user_id' => 1,  // assuming the user_id is 1
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
