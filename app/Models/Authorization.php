<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Authorization extends Model
{
    use HasFactory;

    // Pôvodná tabuľka: opravnenie
    protected $table = 'authorizations';
    protected $guarded = [];

    public $timestamps = false;

    /**
     * Vztah: Authorization ma vela QueenBreeders (id -> opravnenie)
     * Treba to overit, ale predpokladam, ze stlpec 'opravnenie' je FK.
     */
    public function queenBreeders(): HasMany
    {
        return $this->hasMany(QueenBreeder::class, 'opravnenie');
    }
}
