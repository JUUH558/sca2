<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Pôvodná tabuľka: chovatel
     */
    public function up(): void
    {
        Schema::create('breeders', function (Blueprint $table) {
            $table->id();

            // Stĺpce, ktoré nesmú byť NULL
            $table->string('meno', 30);
            $table->string('priezvisko', 40);
            $table->string('skratka_chovu', 4);
            //$table->integer('patri_k_chovatelovi_matiek'); // INT NOT NULL - Pravdepodobne foreign key na `plemenna_matka` alebo inú tabuľku chovateľov.
            $table->foreignId('patri_k_chovatelovi_matiek')->constrained('queen_breeders')->onDelete('cascade');

            // Stĺpce, ktoré môžu byť NULL
            $table->string('titul', 10)->nullable();
            $table->string('CEHZ', 7)->nullable();
            $table->string('adresa', 60)->nullable();
            $table->string('mesto', 50)->nullable();
            $table->string('psc', 6)->nullable();
            $table->string('telefon', 20)->nullable();
            $table->string('mail', 70)->nullable();
            $table->string('poznamka', 200)->nullable();
            $table->unsignedTinyInteger('sposob_odberu_matiek')->nullable(); // tinyint (0-255)
            $table->softDeletes(); // Pridá stĺpec 'deleted_at'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breeders');
    }
};
