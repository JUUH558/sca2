<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Pôvodná tabuľka: opravnenie
     */
    public function up(): void
    {
        Schema::create('authorizations', function (Blueprint $table) {
            $table->id(); // int NOT NULL AUTO_INCREMENT
            $table->string('nazov_opravnenia', 50)->unique();
            $table->integer('uroven')->unique();
            $table->softDeletes(); // Pridá stĺpec 'deleted_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authorizations');
    }
};
