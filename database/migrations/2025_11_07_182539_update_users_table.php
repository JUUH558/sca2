<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Spustí migráciu (pridá stĺpce).
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Pridávame stĺpce z tabuľky queen_breeders do users
            $table->string('skratka_chovu')->unique()->after('id'); // Kľúčový stĺpec pre prihlásenie
            $table->string('meno')->nullable();
            $table->string('priezvisko')->nullable();
            $table->string('titul')->nullable();
            $table->string('CEHZ')->nullable();
            $table->string('adresa')->nullable();
            $table->string('mesto')->nullable();
            $table->string('PSC')->nullable();
            $table->string('telefon')->nullable();
            $table->text('poznamka')->nullable();
            $table->string('link_na_med')->nullable();
            $table->text('text_na_med')->nullable();
            $table->unsignedSmallInteger('opravnenie')->default(0); // Úroveň oprávnenia
            $table->binary('podpis')->nullable(); // Pre BLOB typ
            $table->timestamp('reset_token_expire_at')->nullable();

            // Pridávame Soft Deletes (pretože sa používa v modeli User)
            $table->softDeletes();

            // Odstránenie pôvodného stĺpca 'name', ak bol použitý
            // Ak Laravel používa 'name', môžeme ho premenovať na 'meno' (alebo nechať)
            // Predpokladáme, že sa použije 'meno' a stĺpec 'name' už nie je potrebný.
            if (Schema::hasColumn('users', 'name')) {
                 $table->dropColumn('name');
            }
        });
    }

    /**
     * Vráti späť migráciu (odstráni stĺpce).
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'skratka_chovu',
                'meno',
                'priezvisko',
                'titul',
                'CEHZ',
                'adresa',
                'mesto',
                'PSC',
                'telefon',
                'poznamka',
                'link_na_med',
                'text_na_med',
                'opravnenie',
                'podpis',
                'reset_token_expire_at',
            ]);
            $table->dropSoftDeletes();

            // Voliteľné: Ak bol odstránený, vrátime pôvodný stĺpec 'name'
            if (!Schema::hasColumn('users', 'name')) {
                 $table->string('name')->after('id');
            }
        });
    }
};
