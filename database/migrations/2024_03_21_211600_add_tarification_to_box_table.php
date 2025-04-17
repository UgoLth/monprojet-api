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
            if (!Schema::hasColumn('box', 'tarification_id')) {
                $table->foreignId('tarification_id')->constrained('tarification')->onDelete('cascade');
            }

            // Renommer la colonne surface en superficie si elle existe
            if (Schema::hasColumn('box', 'surface')) {
                $table->renameColumn('surface', 'superficie');
            }
            // Sinon, créer la colonne superficie
            else if (!Schema::hasColumn('box', 'superficie')) {
                $table->decimal('superficie', 8, 2)->comment('Superficie de la box en m²');
            }

            // S'assurer que le numéro est unique pour chaque tarification
            $table->unique(['numero', 'tarification_id']);
        });
    }

    public function down()
    {
        Schema::table('box', function (Blueprint $table) {
            // Supprimer la contrainte d'unicité
            $table->dropUnique(['numero', 'tarification_id']);
            
            // Supprimer la clé étrangère et la colonne tarification_id
            if (Schema::hasColumn('box', 'tarification_id')) {
                $table->dropForeign(['tarification_id']);
                $table->dropColumn('tarification_id');
            }

            // Renommer superficie en surface si elle existe
            if (Schema::hasColumn('box', 'superficie')) {
                $table->renameColumn('superficie', 'surface');
            }
        });
    }
};
