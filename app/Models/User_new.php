<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail; // Ak chcete použiť verifikáciu emailu

/**
 * Tento model slúži ako hlavný autentifikačný model aplikácie.
 * Nahradil pôvodný 'User' model a spája sa s tabuľkou 'queen_breeders'.
 *
 * @property string $skratka_chovu
 * @property string $password
 * @property int $opravnenie
 * @property string $CEHZ
 * @property int $id
 */

class User extends Authenticatable // Model premenovaný na User
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    // DÔLEŽITÉ: Definovanie názvu tabuľky, aby Laravel vedel, že má používať 'queen_breeders'
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
        'password',
        'opravnenie',
        'link_na_med',
        'text_na_med',
        // Ak potrebujete, môžete pridať aj štandardné polia ako 'email'
        'email',
    ];

    // Skrytie citlivých atribútov pri serializácii
    protected $hidden = [
        'password',
        'reset_token',
        'podpis',
        'remember_token', // Pre kompatibilitu s Laravelom
    ];

    // Atribúty, ktoré by mali byť pretypované
    protected function casts(): array
    {
        return [
            'reset_token_expire_at' => 'datetime',
            'opravnenie' => 'integer',
            'password' => 'hashed', // Používame 'hashed'
        ];
    }
    public function findForPassport(string $username): ?User
    {
        // $username je hodnota, ktorú používateľ zadá do prihlasovacieho poľa
        return self::where('skratka_chovu', $username)->first();
    }

    // Metóda pre získanie prihlasovacieho mena (Ak používate 'skratka_chovu' pre prihlásenie)
    public function getAuthIdentifierName()
    {
        // Ak sa používatelia prihlasujú pomocou 'mail' (email), použite: 'mail'
        return 'skratka_chovu';
    }
}
