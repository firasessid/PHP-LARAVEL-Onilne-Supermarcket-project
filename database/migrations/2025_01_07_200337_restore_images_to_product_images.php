

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
        // Restaurer les images depuis la table 'products' vers 'product_images'
        $products = DB::table('products')->get();

        foreach ($products as $product) {
            if ($product->image) {
                DB::table('product_images')->insert([
                    'product_id' => $product->id,
                    'image' => $product->image,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Si nécessaire, vous pouvez vider la table 'product_images' ici
        Schema::table('product_images', function (Blueprint $table) {
            DB::table('product_images')->truncate();
        });
    }
};

