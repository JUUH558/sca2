<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes; // Dôležitý import!

class Breeder extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'breeders';

    protected $guarded = [];

    protected $fillable = [
        'meno', 'priezvisko', 'adresa', 'mesto', 'psc', 'deleted_at', 'titul', 'telefon', 'mail', 'CEHZ', 'patri_k_chovatelovi_matiek', 'skratka_chovu',
        // ... ostatné polia
    ];

    /**
     * Relácia: Chovateľ patrí k jednému Chovateľovi Matiek (QueenBreeder).
     */
    // public function QueenBreeder(): BelongsTo
    public function Breeder(): BelongsTo
    {
        // 'patri_k_chovatelovi_matiek' je cudzí kľúč odkazujúci na QueenBreeder ID
        return $this->belongsTo(QueenBreeder::class, 'patri_k_chovatelovi_matiek');
    }

    // Pomocná metóda pre formuláre: meno, priezvisko (adresa, mesto)
    /*     public function getDisplayLabelAttribute(): string
        {
            return "{$this->meno} {$this->priezvisko} ({$this->adresa ?? 'Nezadaná adresa'}, {$this->mesto ?? 'Nezadané mesto'})";
        }
     */
    public function getDisplayLabelAttribute(): string
    {
        // Najprv zistiť hodnoty, ak sú null, použiť predvolené.
        $adresa = $this->adresa ?? 'Nezadaná adresa';
        $mesto = $this->mesto ?? 'Nezadané mesto';

        // Teraz použijeme premenné v jednoduchej interpolácii.
        return "{$this->meno} {$this->priezvisko} ({$adresa}, {$mesto})";
    }

    // Vzťah k Matkám (Queens)
    public function queens(): HasMany
    {
        // Predpokladáme, že cudzí kľúč v tabuľke 'queens' je stále 'chovatel_id'.
        return $this->hasMany(Queen::class, 'chovatel_id', 'id');
    }

    // Ďalšie modely (Line, Rating, Inseminator, atď.) budú mať podobnú štruktúru
}
