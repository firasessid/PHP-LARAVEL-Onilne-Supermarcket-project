<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the 'product_images' table exists before inserting
        if (Schema::hasTable('product_images')) {
            $products = DB::table('products')->get();

            foreach ($products as $product) {
                if (!empty($product->image)) {
                    DB::table('product_images')->insert([
                        'product_id' => $product->id,
                        'image' => $product->image,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        } else {
            throw new Exception('The "product_images" table does not exist. Please create it first.');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Truncate 'product_images' to remove restored data if necessary
        if (Schema::hasTable('product_images')) {
            DB::table('product_images')->truncate();
        }
    }
};
