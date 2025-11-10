<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    // Pôvodná tabuľka: hodnotenie
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
