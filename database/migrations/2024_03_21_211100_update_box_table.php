<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('box', function (Blueprint $table) {
            // Supprimer les anciennes colonnes si elles existent
            if (Schema::hasColumn('box', 'hebergement_id')) {
                $table->dropForeign(['hebergement_id']);
                $table->dropColumn('hebergement_id');
            }
            if (Schema::hasColumn('box', 'typegardiennage_id')) {
                $table->dropForeign(['typegardiennage_id']);
                $table->dropColumn('typegardiennage_id');
            }
            
            // Ajouter la nouvelle colonne tarification_id
            if (!Schema::hasColumn('box', 'tarification_id')) {
                $table->foreignId('tarification_id')->constrained('tarification')->onDelete('cascade');
            }

            // Ajouter la colonne superficie si elle n'existe pas
            if (!Schema::hasColumn('box', 'superficie')) {
                $table->decimal('superficie', 8, 2)->comment('Superficie de la box en m²');
            }

            // S'assurer que le numéro est unique pour chaque tarification
            $table->unique(['numero', 'tarification_id']);
        });
    }

    public function down()
    {
        Schema::table('box', function (Blueprint $table) {
            // Supprimer les nouvelles colonnes
            $table->dropForeign(['tarification_id']);
            $table->dropColumn('tarification_id');
            if (Schema::hasColumn('box', 'superficie')) {
                $table->dropColumn('superficie');
            }
            $table->dropUnique(['numero', 'tarification_id']);
        });
    }
};
