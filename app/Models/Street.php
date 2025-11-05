<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Street extends Model
{
    use HasFactory;

    // Pôvodná tabuľka: ulice
    protected $table = 'streets';
    protected $guarded = [];

    public $timestamps = false;

    /**
     * Vztah: Street patri k jednej Village (obec_id -> id)
     */
    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class, 'obec_id');
    }
}
