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
        // 1. Table pension
        Schema::create('pension', function (Blueprint $table) {
            $table->id();
            $table->string('Ville');
            $table->string('Adresse');
            $table->string('Telephone');
            $table->string('Responsable');
            $table->timestamps();
        });

        // 2. Table type_gardiennage
        Schema::create('type_gardiennage', function (Blueprint $table) {
            $table->id();
            $table->string('Libelle');
            $table->timestamps();
        });

        // 3. Table tarification
        Schema::create('tarification', function (Blueprint $table) {
            $table->id();
            $table->foreignId('TypeGardiennage_id')->constrained('type_gardiennage');
            $table->decimal('Tarif', 10, 2);
            $table->foreignId('pension_id')->constrained('pension');
            $table->timestamps();
        });

        // 4. Table box
        Schema::create('box', function (Blueprint $table) {
            $table->id();
            $table->string('numero');
            $table->decimal('superficie', 10, 2);
            $table->foreignId('tarification_id')->constrained('tarification');
            $table->timestamps();
            $table->unique(['numero', 'tarification_id'], 'box_numero_tarification_unique');
        });

        // 5. Table proprietaire
        Schema::create('proprietaire', function (Blueprint $table) {
            $table->id();
            $table->string('Nom');
            $table->string('Prenom');
            $table->string('Adresse');
            $table->string('Telephone');
            $table->string('Email')->unique();
            $table->timestamps();
        });

        // 6. Table animal
        Schema::create('animal', function (Blueprint $table) {
            $table->id();
            $table->string('Nom');
            $table->string('Type');
            $table->string('Race');
            $table->foreignId('proprietaire_id')->constrained('proprietaire');
            $table->timestamps();
        });

        // 7. Table affectation
        Schema::create('affectation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')->constrained('animal');
            $table->date('DateDebut');
            $table->date('DateFin');
            $table->timestamps();
        });

        // 8. Table affectation_box (table pivot)
        Schema::create('affectation_box', function (Blueprint $table) {
            $table->foreignId('Box_id')->constrained('box');
            $table->foreignId('Affectation_id')->constrained('affectation');
            $table->primary(['Box_id', 'Affectation_id']);
            $table->timestamps();
        });

        // 9. Table appartenir1 (table pivot entre pension et box)
        Schema::create('appartenir1', function (Blueprint $table) {
            $table->foreignId('Pension_id')->constrained('pension');
            $table->foreignId('Box_id')->constrained('box');
            $table->primary(['Pension_id', 'Box_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Supprimer les tables dans l'ordre inverse de leur création
        Schema::dropIfExists('appartenir1');
        Schema::dropIfExists('affectation_box');
        Schema::dropIfExists('affectation');
        Schema::dropIfExists('animal');
        Schema::dropIfExists('proprietaire');
        Schema::dropIfExists('box');
        Schema::dropIfExists('tarification');
        Schema::dropIfExists('type_gardiennage');
        Schema::dropIfExists('pension');
    }
};
