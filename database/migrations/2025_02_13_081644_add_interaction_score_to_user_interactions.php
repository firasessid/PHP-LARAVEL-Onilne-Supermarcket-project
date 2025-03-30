<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('user_interactions', function (Blueprint $table) {
            $table->integer('interaction_score')->nullable()->after('action_type');
        });
    }

    public function down()
    {
        Schema::table('user_interactions', function (Blueprint $table) {
            $table->dropColumn('interaction_score');
        });
    }
};