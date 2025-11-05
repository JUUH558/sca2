<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // DÔLEŽITÝ IMPORT

class PedigreeQueen extends Model
{
    use HasFactory;
    use SoftDeletes;

    // Pôvodná tabuľka: plemenna_matka
    protected $table = 'pedigree_queens';
    protected $fillable = [
        'id',
        'CEHZ',
        'skratka_chovu',
        'matka_zije',
        'evidencne_cislo',
        'mama_matky',
        'otec_matky',
        'matka_trudova',
        'linia',
        'oznacenie_matky',
        'datum_narodenia',
        'datum_inseminacie',
        'imbreeding',
        'kladie_od',
        'poznamka',
        'umiestnenie',

    ];
    protected $guarded = [];

    public $timestamps = false;

    // Tu by mala byť relácia na Queen (Matka)
}
