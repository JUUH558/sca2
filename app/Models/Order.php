<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;
    public function zakaznik(): BelongsTo
    {
        // Predpokladáme:
        // 1. Zahraničný kľúč v tabuľke 'orders' je 'id_zakaznika'
        // 2. Primárny kľúč v tabuľke 'breeders' (Model Breeder) je 'id'
        return $this->belongsTo(Breeder::class, 'id_zakaznika', 'id');
    }

        public function linia_matky(): BelongsTo
    {
        return $this->belongsTo(Line::class, 'linia', 'id');
    }

    // Pôvodná tabuľka: objednavky
    protected $table = 'orders';
    protected $fillable = [
        'skratka_chovu',
        'datum_objednavky',
        'datum_splnenia',
        'datum_zrusenia',
        'dovod_zrusenia',
        'linia',
        'sposob_oplodnenia',
        'pocet_objednanych',
        'pocet_dodanych',
        'sposob_odberu',
        'poznamka',
        // Pridajte ďalšie polia podľa potreby
    ];
    protected $guarded = [];

    public $timestamps = false;
}
