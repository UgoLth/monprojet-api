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
        Schema::table('box', function (Blueprint $table) {
            // Ajouter la colonne numero
            $table->string('numero')->after('id');
            
            // Supprimer l'ancienne contrainte d'unicité si elle existe
            try {
                $table->dropUnique('box_numero_tarification_unique');
            } catch (\Exception $e) {
                // La contrainte n'existe peut-être pas encore
            }
            
            // Ajouter la nouvelle contrainte d'unicité
            $table->unique(['numero', 'tarification_id'], 'box_numero_tarification_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('box', function (Blueprint $table) {
            // Supprimer la contrainte d'unicité
            $table->dropUnique('box_numero_tarification_unique');
            
            // Supprimer la colonne numero
            $table->dropColumn('numero');
        });
    }
};
