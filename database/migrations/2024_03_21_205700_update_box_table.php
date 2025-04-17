<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('box', function (Blueprint $table) {
            // Supprimer l'ancienne relation avec typegardiennage si elle existe
            if (Schema::hasColumn('box', 'typegardiennage_id')) {
                $table->dropForeign(['typegardiennage_id']);
                $table->dropColumn('typegardiennage_id');
            }
            
            // Ajouter la relation avec hebergement
            if (!Schema::hasColumn('box', 'hebergement_id')) {
                $table->foreignId('hebergement_id')->constrained('hebergement')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('box', function (Blueprint $table) {
            if (Schema::hasColumn('box', 'hebergement_id')) {
                $table->dropForeign(['hebergement_id']);
                $table->dropColumn('hebergement_id');
            }
            
            if (!Schema::hasColumn('box', 'typegardiennage_id')) {
                $table->foreignId('typegardiennage_id')->nullable();
            }
        });
    }
};
