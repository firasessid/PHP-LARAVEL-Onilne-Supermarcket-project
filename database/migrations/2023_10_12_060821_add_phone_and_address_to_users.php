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
        Schema::table('users', function (Blueprint $table) {
            // Add phone column
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable();
            }

            // Add address column
            if (!Schema::hasColumn('users', 'address')) {
                $table->string('address')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop phone column
            $table->dropColumn('phone');

            // Drop address column
            $table->dropColumn('address');
        });
    }
};
