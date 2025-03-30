<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSessionsTable extends Migration
{
    public function up()
    {
        Schema::create('user_sessions', function (Blueprint $table) {
            $table->id();
            
            // Clé étrangère
            $table->foreignId('user_id')
                  ->constrained() // Suppose que la table users existe
                  ->onDelete('cascade');
            
            // Champs de base
            $table->string('ip_address', 45);
            $table->string('device_type', 20);
            $table->string('browser', 20);
            $table->string('location', 100);
            
            // Champs manquants du modèle
            $table->decimal('risk_score', 5, 2)->nullable(); // Ex: 99.99%
            $table->json('metadata')->nullable(); // Pour stocker les données JSON
            
            // Modification du type pour login_time
            $table->dateTime('login_time'); // Plus précis qu'un timestamp
            
            // Extension des types d'action
            $table->enum('action_type', [
                'login',
                'logout',
                'security_incident', // Ajout pour les alertes
                'security_alert'     // Ajout pour les incidents
            ])->default('login');

            $table->timestamps();

            // Index pour les recherches
            $table->index('login_time');
            $table->index('action_type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_sessions');
    }
}