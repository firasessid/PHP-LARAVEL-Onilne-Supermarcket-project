<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('status');
            $table->string('image')->nullable(); // Allow NULL for 'image'
            $table->string('short_description');
            $table->text('description');
            $table->decimal('sale_price');
            $table->decimal('regular_price');
            $table->integer('quantity');
            $table->foreignId('ray_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_category_id')->constrained()->onDelete('cascade');
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('sku');
            $table->enum('is_featured',['Yes','No']);
            $table->boolean('is_approved')->default(0); // Add is_approved with a default value of 0
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Add user_id column

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
