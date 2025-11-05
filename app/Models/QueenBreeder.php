<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes; // DÔLEŽITÝ IMPORT
/**
 * @property string $skratka_chovu
 * @property string $password
 * @property int $opravnenie
 * @property string $CEHZ
 * @property int $id
 */

class QueenBreeder extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes; // PRIDAJTE TENTO TRAIT
    // Definovanie názvu tabuľky, pretože nie je v štandardnom kontexte (users)
    protected $table = 'queen_breeders';
    // Definuje primárny kľúč
    protected $primaryKey = 'id';

    // Definovanie stĺpcov, ktoré sú hromadne priraditeľné (fillable)
    protected $fillable = [
        'meno',
        'priezvisko',
        'titul',
        'CEHZ',
        'skratka_chovu',
        'adresa',
        'mesto',
        'PSC',
        'mail',
        'telefon',
        'poznamka',
        'password',  // Password nahrávame samostatne
        'opravnenie',
        'link_na_med',
        'text_na_med',
    ];

    // Skrytie citlivých atribútov pri serializácii
    protected $hidden = [
        'password',
        'reset_token',
    ];

    // Atribúty, ktoré by mali byť pretypované
    protected $casts = [
        'reset_token_expire_at' => 'datetime',
        'opravnenie' => 'integer',
        // 'podpis' => 'string', // binárne dáta
    ];


    // Kvôli slovenskému názvu stĺpca (defaultne je 'email')
    public function getAuthIdentifierName()
    {
        return 'skratka_chovu'; // Alebo mail, ak používate mail na prihlásenie
    }

    // Kvôli slovenskému názvu stĺpca (defaultne je 'password')
    public function getAuthPassword()
    {
        return $this->password;
    }
}




