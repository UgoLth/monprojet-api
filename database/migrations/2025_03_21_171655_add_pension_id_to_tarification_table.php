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
        Schema::table('tarification', function (Blueprint $table) {
            $table->unsignedBigInteger('pension_id')->after('Tarif');
            $table->foreign('pension_id')->references('id')->on('pensions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tarification', function (Blueprint $table) {
            $table->dropForeign(['pension_id']);
            $table->dropColumn('pension_id');
        });
    }
};
