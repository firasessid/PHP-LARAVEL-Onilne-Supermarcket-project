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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('subtotal');
            $table->decimal('shipping');
            $table->decimal('discount')->nullable();
            $table->decimal('grand_total');
            $table->string('coupon_code')->nullable();
            $table->string('coupon_code_id')->nullable();
            $table->enum('payment_status', ['paid', 'not paid'])->default('not paid');
            $table->enum('status', ['pending', 'shipped', 'delivered'])->default('pending');
            $table->timestamp('shipped_date')->nullable();
            $table->string('payment_method');
            //user adresse related columns
            $table->foreignId('city_id')->constrained()->onDelete('cascade');
            $table->string('adresse');
            $table->string('adresse2');
            $table->string('phone');
            $table->string('zip');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
