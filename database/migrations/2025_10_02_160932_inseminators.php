<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Pôvodná tabuľka: inseminator
     */
    public function up(): void
    {
        Schema::create('inseminators', function (Blueprint $table) {
            $table->id(); // int NOT NULL AUTO_INCREMENT
            $table->string('meno', 30);
            $table->string('priezvisko', 50);
            $table->string('titul', 10);
            $table->string('mail', 60)->nullable()->unique();
            $table->string('telefon', 15)->nullable();
            $table->softDeletes(); // Pridá stĺpec 'deleted_at'
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inseminators');
    }
};
