<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('animaux', function (Blueprint $table) {
            // Supprimer les anciennes colonnes si elles existent
            $table->dropColumn(['race', 'date_naissance']);

            // Ajouter les nouvelles colonnes
            if (!Schema::hasColumn('animaux', 'age')) {
                $table->integer('age')->default(0);
            }
            if (!Schema::hasColumn('animaux', 'poids')) {
                $table->decimal('poids', 8, 2)->default(0);
            }
        });
    }

    public function down()
    {
        Schema::table('animaux', function (Blueprint $table) {
            $table->string('race')->nullable();
            $table->date('date_naissance')->nullable();
            $table->dropColumn(['age', 'poids']);
        });
    }
};
