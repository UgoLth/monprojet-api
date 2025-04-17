<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('hebergement', function (Blueprint $table) {
            // Supprimer les anciennes colonnes si elles existent
            $table->dropForeign(['pension_id']);
            $table->dropForeign(['typegardiennage_id']);
            
            // Recréer les colonnes avec les bonnes contraintes
            $table->foreignId('pension_id')->constrained('pension')->onDelete('cascade');
            $table->foreignId('typegardiennage_id')->constrained('typegardiennage')->onDelete('cascade');
            
            // Ajouter la contrainte d'unicité
            $table->unique(['pension_id', 'typegardiennage_id']);
        });
    }

    public function down()
    {
        Schema::table('hebergement', function (Blueprint $table) {
            $table->dropForeign(['pension_id']);
            $table->dropForeign(['typegardiennage_id']);
            $table->dropUnique(['pension_id', 'typegardiennage_id']);
        });
    }
};
