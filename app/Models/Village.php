<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Village extends Model
{
    use HasFactory;

    // Pôvodná tabuľka: obce
    protected $table = 'villages';
    protected $guarded = [];

    public $timestamps = false; 

    /**
     * Vztah: Village ma vela Streets (obec_id -> id)
     */
    public function streets(): HasMany
    {
        return $this->hasMany(Street::class, 'obec_id');
    }
}
