<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Pôvodná tabuľka: pocet_prihlaseni
     */
    public function up(): void
    {
        Schema::create('login_attempts', function (Blueprint $table) {
            $table->id();

            // Stĺpce
            $table->string('ip_adresa', 15)->unique(); // Zvyčajne by mala byť IP adresa unikátna
            $table->integer('pocet_pokusov')->default(0);

            // Stĺpec posledny_pokus má byť NOT NULL s defaultom CURRENT_TIMESTAMP
            $table->timestamp('posledny_pokus');

            $table->timestamps();

            // Pre zrýchlenie vyhľadávania podľa IP adresy
            $table->index('ip_adresa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_attempts');
    }
};
