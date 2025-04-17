<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('box', function (Blueprint $table) {
            // Ajouter la colonne tarification_id
            $table->foreignId('tarification_id')->nullable()->constrained('tarification');
            
            // Renommer la colonne surface en superficie si elle existe
            if (Schema::hasColumn('box', 'surface')) {
                $table->renameColumn('surface', 'superficie');
            }
            
            // S'assurer que le numéro est unique pour chaque tarification
            $table->unique(['numero', 'tarification_id'], 'box_numero_tarification_unique');
        });
    }

    public function down()
    {
        Schema::table('box', function (Blueprint $table) {
            // Supprimer la contrainte d'unicité
            $table->dropUnique('box_numero_tarification_unique');
            
            // Supprimer la clé étrangère et la colonne tarification_id
            $table->dropForeign(['tarification_id']);
            $table->dropColumn('tarification_id');
            
            // Renommer superficie en surface si elle existe
            if (Schema::hasColumn('box', 'superficie')) {
                $table->renameColumn('superficie', 'surface');
            }
        });
    }
};
