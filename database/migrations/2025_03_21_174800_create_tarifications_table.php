<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarificationsTable extends Migration
{
    public function up()
    {
        Schema::create('tarifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('TypeGardiennage_id')->constrained('typegardiennage');
            $table->decimal('Tarif', 10, 2);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tarifications');
    }
}
