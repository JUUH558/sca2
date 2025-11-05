<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // DÔLEŽITÝ IMPORT

class Inseminator extends Model
{
    use HasFactory;
    use SoftDeletes; // PRIDAJTE TENTO TRAIT

    protected $table = 'inseminators';

    protected $fillable = [
        'meno',
        'priezvisko',
        'titul',
        'telefon',
        'mail',
    ];

    protected $guarded = [];

    /*     public function getDisplayLabelAttribute(): string
        {
            // Najprv zistiť hodnoty, ak sú null, použiť predvolené.
            // $mama = $this->mama_matky ?? 'Nezadaná adresa';
            // $otec = $this->otec_matky ?? 'Nezadané mesto';

            // Teraz použijeme premenné v jednoduchej interpolácii.
            return "{$this->meno} {$this->priezvisko}"; // ({$mama}, {$otec});
        }
      */ // Tu sa pridávajú ďalšie relácie (napr. s Queen, ak by bola relácia namiesto varchar v tabuľke queens)
}
