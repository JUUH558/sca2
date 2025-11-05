<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Vytvorí tabuľku 'seria' pre sledovanie chovných sérií.
     */
    public function up(): void
    {

        Schema::create('series', function (Blueprint $table) {
            // Používame id() pre int NOT NULL AUTO_INCREMENT
            $table->id();

            // Kľúčové identifikačné stĺpce
            $table->tinyInteger('seria'); // NOT NULL
            $table->string('CEHZ', 7);    // NOT NULL
            $table->string('rok', 4);     // NOT NULL
            $table->string('skratka_chovu', 4); // NOT NULL

            // Rodičovské informácie
            $table->string('mama_matky', 10); // NOT NULL
            $table->string('otec_matky', 10)->nullable();

            // Dátumy
            $table->date('datum_zalozenia_serie'); // NOT NULL
            $table->date('datum_liahnutia_matiek'); // NOT NULL

            // Iné atribúty
            $table->string('linia', 25)->nullable();

            // Stĺpce na sledovanie stavu s defaultnou hodnotou 0
            $table->tinyInteger('prelarvovane')->default(0); // NOT NULL, DEFAULT '0'
            $table->tinyInteger('prijate')->default(0);      // NOT NULL, DEFAULT '0'
            $table->tinyInteger('zavieckovane')->default(0); // NOT NULL, DEFAULT '0'
            $table->tinyInteger('vyliahnute')->default(0);   // NOT NULL, DEFAULT '0'
            $table->tinyInteger('oplodnene')->default(0);    // NOT NULL, DEFAULT '0'
            $table->tinyInteger('predane')->default(0);      // NOT NULL, DEFAULT '0'

            // Pôvodné timestampy
            $table->timestamp('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            // Pridanie indexu, ak je CEHZ+rok unikátna kombinácia pre sériu (predpoklad)
            $table->unique(['seria', 'CEHZ', 'rok']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};
