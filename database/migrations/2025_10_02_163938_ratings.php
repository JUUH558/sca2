<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Spustí migráciu. Vytvorí tabuľku 'evaluations'.
     */
    public function up(): void
    {
        // Tabuľka hodnotenie -> evaluations
        Schema::create('ratings', function (Blueprint $table) {
            // Primárny kľúč. Používame integer, lebo nie je AUTO_INCREMENT.
            $table->id();

            // Pôvodný stĺpec 'zapisane'
            $table->timestamp('zapisane')->useCurrent(); // timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP

            // Cudzí kľúč 'hodnotil' (kto hodnotil), predpokladáme odkaz na 'users' alebo 'breeder_users'
            $table->integer('hodnotil')->comment('Kto hodnotil');

            // Ostatné stĺpce
            $table->date('datum');
            $table->string('matka', 10)->charset('utf8mb3')->collation('utf8mb3_slovak_ci');
            $table->string('skratka_chovu', 4)->charset('utf8mb3')->collation('utf8mb3_slovak_ci');

            // Hodnoty s desatinnou čiarkou
            $table->decimal('med', 10, 2)->nullable();
            $table->decimal('hygienicky_test', 10, 2)->nullable();
            $table->decimal('varroa', 10, 2)->nullable();

            // Tinyint - hodnoty 0-255 (používa sa pre malé celočíselné hodnotenia/stupnice)
            $table->tinyInteger('miernost')->nullable();
            $table->tinyInteger('rozbiehavost')->nullable();
            $table->tinyInteger('rojivost')->nullable();
            $table->tinyInteger('stavba_ms')->nullable();
            $table->tinyInteger('zimovanie_pocet_uliciek')->nullable();
            $table->tinyInteger('nozema')->nullable();
            $table->tinyInteger('zasoby')->nullable();

            // Dlhší text
            $table->text('poznamka')->nullable()->charset('utf8mb3')->collation('utf8mb3_slovak_ci');
            $table->softDeletes(); // Pridá stĺpec 'deleted_at'

            // Laravel created_at a updated_at s pôvodnými defaultnými hodnotami
            $table->timestamp('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            // Vytvorenie indexu na cudzí kľúč
            $table->index('hodnotil', 'hodnotenie_hodnotil_foreign');
        });

        // Pridanie obmedzenia cudzím kľúčom
/*          Schema::table('ratings', function (Blueprint $table) {
            // Predpokladáme, že stĺpec 'hodnotil' odkazuje na tabuľku 'breeder_users' (alebo 'users')
            $table->foreign('hodnotil')
                  ->references('id')
                  ->on('breeders')
                  ->onDelete('restrict');

             // Možno bude potrebné pridať cudzí kľúč aj na matku/skratku chovu,
            // ale to by vyžadovalo kompozitný kľúč. Pre zatiaľ to ponecháme len ako stĺpce.
        });
 */    }

    /**
     * Vráti späť migráciu.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
