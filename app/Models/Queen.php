<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Serie;
use App\Models\Breeder;

class Queen extends Model
{
    use HasFactory;

    protected $table = 'queens';

    // Stĺpce, ktoré môžu byť hromadne priradené (mass assignable)
    protected $guarded = [];
    protected $fillable = [
        'seria', // ID série z tabuľky 'series'
        'chovatel_id', // ID chovateľa z tabuľky 'breeders'
        'evidencne_cislo',
        'datum_expedicie',
        'poznamka',
        'mama_matky',
        'otec_matky',
        'linia',
        'inseminoval',
        'chovatel_matiek_id', // ID chovateľa matiek z tabuľky 'queen_breeders'
        'matka_id', // ID matky z tabuľky 'queens'
        'matka_trudov',
        'datum_narodenia',
        'datum_inseminacie',
        'imbreeding',
        'oznacenie_matky',
        'kladie_od',
        'sposob_oplodnenia',
        'chovny_ul',
        'poznamka',
        'CEHZ',
        'skratka_chovu ',
        'rok',

    ];
    /**
     * Relácia: Matka patrí k jednému Chovateľovi Matiek (QueenBreeder).
     */
    public function queenBreeder(): BelongsTo
    {
        return $this->belongsTo(QueenBreeder::class, 'chovatel_matiek_id');
    }

    // Predpokladaná relácia, ak by sme mali prepojiť matku s chovateľom (Breeder)
    /*     public function breeder(): BelongsTo
    {
        return $this->belongsTo(Breeder::class, 'chovatel_id');
    }
 */

    protected $hidden=[
        'qrcode',
        ];

    public function serie(): BelongsTo
    {
        return $this->belongsTo(Serie::class, 'seria', 'id')
            ->where('skratka_chovu', session('skratka_chovu') )
            //->where('skratka_chovu', 'UHJ')
            ->where('rok', date('Y'));
    }

    /**
     * Vzťah k tabuľke 'breeders' (Breeder).
     */
    public function breeder(): BelongsTo
    {
        return $this->belongsTo(Breeder::class, 'chovatel_id', 'id');
    }
    public function line(): BelongsTo
    {
        return $this->belongsTo(Breeder::class, 'linia', 'id');
    }
    public function inseminator(): BelongsTo
    {
        return $this->belongsTo(Breeder::class, 'inseminoval', 'id');
    }
}
    // Ďalšie relácie by tu mali byť definované, napr. s hodnotením (Rating)
