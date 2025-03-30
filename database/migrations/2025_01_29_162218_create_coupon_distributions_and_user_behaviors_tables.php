<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Création de la table coupon_distributions
        Schema::create('coupon_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('coupon_id')->constrained()->onDelete('cascade');
            $table->decimal('confidence', 5, 2);
            $table->timestamp('sent_at');
            $table->timestamp('used_at')->nullable();
            $table->json('model_metadata')->nullable();
            $table->string('model_version');
            $table->decimal('revenue_impact', 10, 2)->nullable();
            $table->timestamps();
        });

        // Création de la table user_behaviors
        Schema::create('user_behaviors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('engagement_score', 5, 2);
            $table->json('preferences')->nullable();
            $table->json('interaction_history');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('coupon_distributions');
        Schema::dropIfExists('user_behaviors');
    }
};
