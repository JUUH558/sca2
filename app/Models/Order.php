<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

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
