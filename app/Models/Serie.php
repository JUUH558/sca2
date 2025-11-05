<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    use HasFactory;

    // Pôvodná tabuľka: seria
    protected $table = 'series';
    protected $guarded = [];
protected $fillable = [
        'seria', // Séria,
        'skratka_chovu', // Skratka chovu, napr. "UHJ"
        'rok', // Rok, napr. 2023
        'datum_zalozenia_serie', // Dátum založenia série
        'mama_matky', // Mama matky
        'otec_matky', // Otec matky
    ];
    //public $timestamps = false;

    public function getDisplayLabelAttribute(): string
    {
        // Najprv zistiť hodnoty, ak sú null, použiť predvolené.
        $mama = $this->mama_matky ?? 'Nezadaná mama';
        $otec = $this->otec_matky ?? 'Nezadaný otec';

        // Teraz použijeme premenné v jednoduchej interpolácii.
        return "{$this->seria} {$this->datum_zalozenia_serie} ({$mama}, {$otec})";
    }
}
