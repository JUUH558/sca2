<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    use HasFactory;

    // Pôvodná tabuľka: pocet_prihlaseni
    protected $table = 'login_attempts';
    protected $guarded = [];

    // Vypnutie automatického timestampu (ak nebol v DB)
    public $timestamps = false;
}
