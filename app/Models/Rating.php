<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Rating extends Model
{
    use HasFactory;
    public function zakaznik(): BelongsTo
    {
        // Predpokladáme:
        // 1. Zahraničný kľúč v tabuľke 'orders' je 'id_zakaznika'
        // 2. Primárny kľúč v tabuľke 'breeders' (Model Breeder) je 'id'
        return $this->belongsTo(Breeder::class, 'hodnotil', 'id');
    }
/**
     * Vypočíta priemerné hodnotenie zo všetkých posudzovaných charakteristík.
     */
    protected function priemernaHodnota(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                // Počet stĺpcov, ktoré sa majú spriemerovať
                $pocetStlpcov = 9;

                // Zoznam stĺpcov, ktoré chcete spriemerovať
                $stlpcovNaSpriemerovanie = [
                    'hygienicky_test',
                    'varroa',
                    'miernost',
                    'rozbiehavost',
                    'rojivost',
                    'stavba_ms',
                    'zimovanie_pocet_uliciek',
                    'nozema',
                    'zasoby',
                ];

                $sucet = 0;

                // Sčítanie hodnôt stĺpcov
                foreach ($stlpcovNaSpriemerovanie as $stlpec) {
                    // Používame intval() pre konverziu na celé číslo, aj keď by mali byť numerické
                    $sucet += (int) $attributes[$stlpec];
                }

                // Výpočet priemeru (zaokrúhlené na dve desatinné miesta)
                return round($sucet / $pocetStlpcov, 2);
            },
        );
    }    // Pôvodná tabuľka: hodnotenie
    protected $table = 'ratings';

    protected $fillable = [
        'skratka_chovu',
        'zapisane',
        'matka',
        'skratka_chovu',
        'hodnotil',
        'med',
        'hygienicky_test',
        'varroa',
        'miernost',
        'rozbiehavost',
        'rojivost',
        'stavba_ms',
        'zimovanie_pocet_uliciek',
        'nozema',
        'poznamka',
        'zasoby',
    ];

    protected $guarded = [];

    public $timestamps = false;

    // Relácie s Queen (Matka) by sa mali definovať tu, ak sú prepojené.
}
