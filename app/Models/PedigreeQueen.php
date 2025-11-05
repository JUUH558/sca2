<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedigreeQueen extends Model
{
    use HasFactory;

    // Pôvodná tabuľka: plemenna_matka
    protected $table = 'pedigree_queens';
    protected $guarded = [];

    public $timestamps = false;

    // Tu by mala byť relácia na Queen (Matka)
}
