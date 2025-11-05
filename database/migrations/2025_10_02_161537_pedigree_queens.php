<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Pôvodná tabuľka: plemenna_matka
     */
    public function up(): void
    {
        Schema::create('pedigree_queens', function (Blueprint $table) {
            $table->id(); // int NOT NULL AUTO_INCREMENT
            $table->string('CEHZ', 7);
            $table->string('skratka_chovu', 4);
            $table->boolean('matka_zije');
            $table->string('evidencne_cislo', 10);
            $table->string('mama_matky', 10);
            $table->string('otec_matky', 10);
            $table->string('matka_trudov', 10)->nullable();
            $table->string('linia', 30);
            $table->string('oznacenie_matky', 4);
            $table->date('datum_narodenia')->nullable();
            $table->date('datum_inseminacie')->nullable();
            $table->string('imbreeding', 4)->nullable();
            $table->date('kladie_od')->nullable();
            $table->string('umiestnenie', 10)->nullable();
            $table->string('poznamka', 200)->nullable();
            $table->softDeletes(); // Pridá stĺpec 'deleted_at'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedigree_queens');
    }
};
