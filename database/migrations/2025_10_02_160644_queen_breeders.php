<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Pôvodná tabuľka: chovatel_matiek
     */
    public function up(): void
    {
        Schema::create('queen_breeders', function (Blueprint $table) {
             $table->id(); // Laravel konvencia pre AUTO_INCREMENT primary key
            $table->string('meno', 30);
            $table->string('priezvisko', 50);
            $table->string('titul', 10)->nullable();
            $table->string('CEHZ', 7)->unique(); // Pôvodne NOT NULL, pridaný unique index
            $table->string('skratka_chovu', 5); // Pôvodne NOT NULL

            // Adresa a kontakt
            $table->string('adresa', 50)->nullable();
            $table->string('mesto', 40)->nullable();
            $table->string('PSC', 6)->nullable();
            $table->string('mail', 60)->nullable();
            $table->string('telefon', 15)->nullable();
            $table->string('poznamka', 100)->nullable();

            // Autentifikačné a systémové dáta
            $table->string('password', 255)->nullable();
            // CHYBA OPRAVENÁ: Ponechávame pôvodný názov stĺpca 'opravnenie'
            $table->unsignedTinyInteger('opravnenie'); // Pôvodne TINYINT NOT NULL
            $table->binary('podpis')->nullable(); // Pôvodne BLOB
            $table->string('link_na_med', 45)->nullable();
            $table->string('text_na_med', 18)->nullable();
            $table->softDeletes(); // Pridá stĺpec 'deleted_at'

            // Reset tokeny
            $table->string('reset_token', 255)->nullable();
            $table->timestamp('reset_token_expire_at')->nullable();
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queen_breeders');
    }
};
