<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Vytvorí tabuľku 'obce' pre zoznam obcí.
     */
    public function up(): void
    {
        Schema::create('villages', function (Blueprint $table) {
            // Používame id() pre automatický AUTO_INCREMENT
            $table->id(); // int NOT NULL AUTO_INCREMENT

            // Stĺpce
            $table->string('dobec', 60); // Dlhý názov obce?
            $table->string('obec', 60); // Názov obce
            $table->string('okres', 60); // Názov okresu
            $table->string('psc', 6); // PSČ (Poštové smerovacie číslo)
            $table->string('dposta', 60); // Dlhý názov pošty?
            $table->string('posta', 60); // Názov pošty
            $table->string('kod_okresu', 5); // Kód okresu
            $table->string('kraj', 3); // Kód kraja

            $table->timestamps();

            // Poznámka: Pôvodná tabuľka mala ENGINE=InnoDB, čo je štandardom Laravelu,
            // takže nie je potrebné špeciálne nastavovať engine.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('villages');
    }
};
