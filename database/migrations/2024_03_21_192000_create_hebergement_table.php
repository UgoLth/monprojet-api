<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hebergement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pension_id')->constrained('pension')->onDelete('cascade');
            $table->foreignId('type_gardiennage_id')->constrained('type_gardiennage')->onDelete('cascade');
            $table->decimal('tarif', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hebergement');
    }
};
