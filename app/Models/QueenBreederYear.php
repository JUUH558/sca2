<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QueenBreederYear extends Model
{
    use HasFactory;

    // Pôvodná tabuľka: chovatel_m_rok
    protected $table = 'queen_breeder_years';
    protected $fillable = [
        'chovatel_matiek_id',
        'rok',
        'datum_povolenia_RVPS',
        'cislo_dekretu',
        'typ_chovu',
        'skratka_chovu',
        'RVPS',
    ];

    public $timestamps = false;

    /**
     * Vztah: QueenBreederYear patri k jednému QueenBreeder (chovatel_matiek_id -> id)
     */
    public function queenBreeder(): BelongsTo
    {
        return $this->belongsTo(QueenBreeder::class, 'chovatel_matiek_id');
    }
}
