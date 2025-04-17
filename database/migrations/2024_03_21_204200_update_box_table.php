<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('box', function (Blueprint $table) {
            // Supprimer l'ancienne colonne hebergement_id si elle existe
            if (Schema::hasColumn('box', 'hebergement_id')) {
                $table->dropForeign(['hebergement_id']);
                $table->dropColumn('hebergement_id');
            }
            
            // Ajouter la nouvelle colonne type_gardiennage_id
            if (!Schema::hasColumn('box', 'type_gardiennage_id')) {
                $table->foreignId('type_gardiennage_id')->constrained('type_gardiennage')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('box', function (Blueprint $table) {
            if (Schema::hasColumn('box', 'type_gardiennage_id')) {
                $table->dropForeign(['type_gardiennage_id']);
                $table->dropColumn('type_gardiennage_id');
            }
            
            if (!Schema::hasColumn('box', 'hebergement_id')) {
                $table->foreignId('hebergement_id')->nullable();
            }
        });
    }
};
