<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Colonnes existantes - ne pas modifier
            // Ajout des nouvelles colonnes nécessaires
            $table->integer('loyalty_points')->default(0)->after('updated_at');
            $table->string('segment', 50)->nullable()->after('loyalty_points');
            $table->integer('age')->nullable()->after('segment');
            $table->decimal('purchase_frequency', 5, 2)->default(0.00)->after('age');
            $table->decimal('avg_spending', 10, 2)->default(0.00)->after('purchase_frequency');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'loyalty_points',
                'segment',
                'age',
                'purchase_frequency',
                'avg_spending'
            ]);
        });
    }
};