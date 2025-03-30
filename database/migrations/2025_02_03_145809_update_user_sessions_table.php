<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserSessionsTable extends Migration
{
    public function up()
    {
        Schema::table('user_sessions', function (Blueprint $table) {
            // Ajouter les nouveaux champs
            $table->decimal('risk_score', 5, 2)->nullable()->after('location');
            $table->json('metadata')->nullable()->after('risk_score');
            
            // Modifier le type de login_time
            $table->dateTime('login_time')->change();
            
            // Étendre l'enum action_type
            $table->enum('action_type', [
                'login',
                'logout',
                'security_incident',
                'security_alert'
            ])->default('login')->change();
        });
    }

    public function down()
    {
        Schema::table('user_sessions', function (Blueprint $table) {
            // Supprimer les nouveaux champs
            $table->dropColumn(['risk_score', 'metadata']);
            
            // Revenir au type d'origine pour login_time
            $table->timestamp('login_time')->change();
            
            // Revenir à l'enum d'origine pour action_type
            $table->enum('action_type', ['login', 'logout'])->default('login')->change();
        });
    }
}