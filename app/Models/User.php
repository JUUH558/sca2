<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str; // DÔLEŽITÝ IMPORT PRE ACCESSOR

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'skratka_chovu',
        'email',
        'password',
        'meno',
        'priezvisko',
        'titul',
        'CEHZ',
        'adresa',
        'mesto',
        'PSC',
        'telefon',
        'poznamka',
        'link_na_med',
        'text_na_med',
        'opravnenie',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'podpis',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'reset_token_expire_at' => 'datetime',
            'opravnenie' => 'integer',
        ];
    }

    // --- RIEŠENIE PRE FILAMENT & LARAVEL ---

    /**
     * Definuje virtuálnu vlastnosť 'name', ktorú očakáva Laravel a Filament.
     */
    protected function name(): Attribute
    {
        return Attribute::get(function (mixed $value, array $attributes) {

            // 1. Priorita: Meno a Priezvisko (ak existujú)
            $fullName = trim("{$this->titul} {$this->meno} {$this->priezvisko}");

            if (! empty($fullName)) {
                return $fullName;
            }

            // 2. Priorita: Skratka chovu
            if (! empty($this->skratka_chovu)) {
                return $this->skratka_chovu;
            }

            // 3. Priorita: Email (odstránime text za @)
            if (! empty($this->email)) {
                return Str::before($this->email, '@').' (E-mail)';
            }

            // 4. Fallback: Garancia, že VŽDY vrátime string
            return 'Neznámy Používateľ ID:'.$this->id;
        });
    }

    /**
     * Metóda, ktorú Filament môže tiež použiť (volá internú vlastnosť name).
     */
    public function getFilamentName(): string
    {
        // Využije Accessor 'name' definovaný vyššie, ktorý garantuje string.
        return $this->name;
    }
}
