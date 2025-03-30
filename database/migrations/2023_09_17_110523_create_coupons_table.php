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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name')->nullable();
            $table->text('max_uses')->nullable();
            $table->text('max_uses_user')->nullable();
            $table->enum('type', ['percent', 'fixed'])->default('fixed');
            $table->double('discount_amount', 10, 2);
            $table->double('min_amount', 10, 2)->nullable();
            $table->integer('status')->default(1);
            $table->string('target_segment');
            $table->integer('points_required');
            $table->timestamp('starts_at')->nullable();
            $table->timestamp(column: 'expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
