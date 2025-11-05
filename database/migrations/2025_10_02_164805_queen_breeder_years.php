<?php

use Carbon\Traits\Timestamp;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Spustí migráciu. Vytvorí tabuľku 'queen_breeder_years'.
     */
    public function up(): void
    {
        // Tabuľka chovatel_m_rok -> queen_breeder_years
        Schema::create('queen_breeder_years', function (Blueprint $table) {
            // Používame integer pre 'id', lebo nie je AUTO_INCREMENT v pôvodnej schéme.
            // Dátam z importu toto priradí ID, ak chceme, aby fungovali s Eloquentom.
            $table->id();

            // Pôvodné stĺpce
            $table->string('CEHZ', 7)->charset('utf8mb3')->collation('utf8mb3_slovak_ci');
            $table->string('skratka_chovu', 4)->charset('utf8mb3')->collation('utf8mb3_slovak_ci');
            $table->string('typ_chovu', 15)->nullable()->charset('utf8mb3')->collation('utf8mb3_slovak_ci');
            $table->string('rok', 4)->charset('utf8mb3')->collation('utf8mb3_slovak_ci');
            $table->date('datum_povolenia_RVPS')->nullable();
            $table->string('cislo_dekretu', 12)->nullable()->charset('utf8mb3')->collation('utf8mb3_slovak_ci');
            $table->string('RVPS', 50)->charset('utf8mb3')->collation('utf8mb3_slovak_ci');

            // Cudzí kľúč k tabuľke chovatel_matiek (breeder_users)
            // Pôvodne int NOT NULL
            $table->integer('chovatel_matiek_id');

            // Preskočíme 'zaznam_vytvoreny' a 'posledna_zmena', nahradené Laravel timestamps
             $table->timestamp('zaznam_vytvoreny')->useCurrent()->useCurrentOnUpdate();

            // `posledna_zmena` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
            // V Laravel migrácia neumožňuje pridať stĺpec created_at, preto použijeme vlastnú definíciu.
            $table->timestamp('posledna_zmena')->useCurrent();
              $table->timestamps();

            // Vytvorenie indexu na cudzí kľúč
            $table->index('chovatel_matiek_id', 'chovatel_m_rok_chovatel_matiek_id_foreign');
        });

        // Pridanie obmedzenia cudzím kľúčom (po vytvorení tabuľky)
 /*        Schema::table('queen_breeder_years', function (Blueprint $table) {
            $table->foreign('chovatel_matiek_id')
                  ->references('id')
                  ->on('breeder_users') // Predpokladáme, že 'chovatel_matiek' bola premenovaná na 'breeder_users'
                  ->onDelete('restrict');
        });
 */    }

    /**
     * Vráti späť migráciu.
     */
    public function down(): void
    {
        Schema::dropIfExists('queen_breeder_years');
    }
};
