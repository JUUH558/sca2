<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Na použitie DB::raw pre timestampy

return new class extends Migration
{
    /**
     * Run the migrations.
     * Vytvorí tabuľku 'lines' (pôvodne 'linia') so slovenskými názvami stĺpcov.
     */
    public function up(): void
    {
        Schema::create('lines', function (Blueprint $table) {
            // Ponechávame pôvodný stĺpec 'id' ako unsignedInteger a primárny kľúč,
            // pretože AUTO_INCREMENT sa pridáva až v ALTER TABLE.
            $table->id();

            // Pôvodné slovenské názvy stĺpcov:
            $table->string('meno_line', 40);
            $table->string('skratka_linie', 4);
            $table->string('povodca_linie', 100);

            // tinyint NOT NULL s pôvodným komentárom
            $table->tinyInteger('typ_line')
                ->comment('1-uznaná,2-importovaná,3-iná');
            $table->softDeletes(); // Pridá stĺpec 'deleted_at'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lines');
    }
};
