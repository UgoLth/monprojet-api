<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyAnimalsTableNullableFields extends Migration
{
    public function up()
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->string('race')->nullable()->change();
            $table->date('date_naissance')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->string('race')->nullable(false)->change();
            $table->date('date_naissance')->nullable(false)->change();
        });
    }
}
