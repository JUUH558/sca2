<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queens', function (Blueprint $table) {
            $table->id(); // int NOT NULL AUTO_INCREMENT

            // Cudzí kľúč na queen_breeders
            $table->foreignId('chovatel_matiek_id')->constrained('queen_breeders')->onDelete('cascade');

            $table->string('matka_id', 25)->unique();
            $table->string('evidencne_cislo', 10)->unique();
            $table->string('mama_matky', 10)->nullable();
            $table->string('otec_matky', 10)->nullable();
            $table->string('matka_trudov', 10)->nullable();
            $table->date('datum_narodenia')->nullable();
            $table->date('datum_inseminacie')->nullable();
            $table->string('inseminoval', 40)->nullable();
            $table->string('imbreeding', 5)->nullable();
            $table->string('linia', 30)->nullable(); // Pôvodne nebola foreign key
            $table->string('oznacenie_matky', 5)->nullable();
            $table->date('kladie_od')->nullable();
            $table->string('sposob_oplodnenia', 20)->nullable();
            $table->date('datum_expedicie')->nullable();

            // Cudzí kľúč na breeders
            $table->integer('chovatel_id')->nullable()->index(); // Pôvodne nebola foreign key

            $table->tinyInteger('seria')->nullable();
            $table->string('chovny_ul', 10)->nullable();
            $table->string('poznamka', 100)->nullable();
            $table->string('CEHZ', 7);
            $table->string('skratka_chovu', 4)->index();
            $table->string('rok', 4)->index();
            $table->string('https_link', 100);
            $table->binary('qrcode');
            $table->boolean('tlac')->default(false);
            $table->boolean('editovat')->default(false);
            $table->timestamps();

            // Pridanie chýbajúceho FK:
            // $table->foreign('chovatel_id')->references('id')->on('breeders')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('queens');
    }
};
