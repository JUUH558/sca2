<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Vytvorí tabuľku 'objednavky' so slovenskými názvami stĺpcov.
     */
    public function up(): void
    {
        // Pôvodný SQL:
        // CREATE TABLE `objednavky` (
        //   `id` int NOT NULL,
        //   ...
        //   `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
        //   `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        // ) ENGINE=MyISAM ...;

        Schema::create('orders', function (Blueprint $table) {
            // Používame id() pre int NOT NULL AUTO_INCREMENT
            $table->id();

            // Stĺpce
            $table->string('skratka_chovu', 4)->nullable();
            $table->date('datum_objednavky')->nullable();
            $table->date('datum_splnenia')->nullable();
            $table->date('datum_zrusenia')->nullable();

            // tinyint s komentárom
            $table->tinyInteger('dovod_zrusenia')
                  ->nullable()
                  ->comment('1-pred oznámenín, 2-po oznámení');

            $table->string('linia', 30)->nullable();
            $table->string('sposob_oplodnenia', 20)->nullable();

            // tinyint pre malé číselné hodnoty
            $table->tinyInteger('pocet_objednanych')->nullable();
            $table->tinyInteger('pocet_dodanych')->nullable();

            $table->integer('id_zakaznika')->nullable();
            $table->string('rok', 4)->nullable();

            $table->tinyInteger('sposob_odberu')->nullable();
            $table->string('poznamka', 100)->nullable();
            $table->softDeletes(); // Pridá stĺpec 'deleted_at'

                       $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
