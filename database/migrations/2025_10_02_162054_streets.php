<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Vytvorí tabuľku 'ulice' pre ukladanie adresných údajov a obcí.
     */
    public function up(): void
    {

        Schema::create('streets', function (Blueprint $table) {
            // Používame id() pre int NOT NULL AUTO_INCREMENT
            $table->id();

            // Adresné stĺpce (ulica, pošta, PSČ)
            $table->string('dulica', 60);  // Dlhý názov ulice (NOT NULL)
            $table->string('ulica', 60);   // Krátky názov ulice (NOT NULL)
            $table->string('psc', 6);      // Poštové smerovacie číslo (NOT NULL)
            $table->string('dposta', 60);  // Dlhý názov pošty/miesta (NOT NULL)
            $table->string('posta', 60);   // Krátky názov pošty/miesta (NOT NULL)
            $table->string('obce', 60);    // Názov obce (NOT NULL)
            $table->string('poznamka', 100); // Poznámka (NOT NULL)

                         $table->timestamps();

            // Pridanie indexu pre rýchle vyhľadávanie podľa PSČ
            $table->index('psc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('streets');
    }
};
