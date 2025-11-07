<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\QueenBreeder; // Starý model
use App\Models\User;         // Nový (upravený) model
use Illuminate\Support\Str; // Pre generovanie náhodných reťazcov

class MigrateQueenBreedersToUsersSeeder extends Seeder
{
    /**
     * Spustí presun dát.
     */
    public function run(): void
    {
        // Kontrola, či existujú nejakí chovatelia na presun
        $breederCount = QueenBreeder::count();

        if ($breederCount === 0) {
            $this->command->info('Tabuľka queen_breeders je prázdna. Presun preskočený.');
            return;
        }

        $this->command->info("Začínam presun dát z queen_breeders do users ({$breederCount} záznamov)...");

        // Získanie všetkých záznamov zo starej tabuľky
        $breeders = QueenBreeder::all();

        DB::transaction(function () use ($breeders) {
            foreach ($breeders as $breeder) {

                // 1. Zabezpečenie unikátneho e-mailu
                $emailValue = $breeder->mail;

                // Ak je e-mail prázdny (''), null, alebo je to nejaký nevalidný údaj,
                // vytvoríme dočasný unikátny e-mail.
                if (empty($emailValue)) {
                    // Generovanie unikátneho dočasného e-mailu: skratka_chovu + unikátny token
                    $emailValue = strtolower($breeder->skratka_chovu) . '-' . Str::random(5) . '@temp.sk';
                }

                // 2. Kontrola, či už takýto e-mail neexistuje (len pre istotu)
                if (User::where('email', $emailValue)->exists()) {
                    $emailValue = strtolower($breeder->skratka_chovu) . '-' . Str::random(5) . '@conflict.sk';
                }

                // Mapovanie stĺpcov
                $userData = [
                    'skratka_chovu' => $breeder->skratka_chovu,
                    // POUŽÍVAME OPRAVENÚ HODNOTU E-MAILU
                    'email'         => $emailValue,
                    'password'      => $breeder->password,

                    'meno'          => $breeder->meno,
                    'priezvisko'    => $breeder->priezvisko,
                    'titul'         => $breeder->titul,
                    'CEHZ'          => $breeder->CEHZ,
                    'adresa'        => $breeder->adresa,
                    'mesto'         => $breeder->mesto,
                    'PSC'           => $breeder->PSC,
                    'telefon'       => $breeder->telefon,
                    'poznamka'      => $breeder->poznamka,
                    'link_na_med'   => $breeder->link_na_med,
                    'text_na_med'   => $breeder->text_na_med,
                    'opravnenie'    => $breeder->opravnenie,
                    'podpis'        => $breeder->podpis,

                    'reset_token_expire_at' => $breeder->reset_token_expire_at,
                    'created_at'    => $breeder->created_at,
                    'updated_at'    => $breeder->updated_at,
                    'deleted_at'    => $breeder->deleted_at,
                ];

                // Vytvorenie nového záznamu v tabuľke users
                User::create($userData);
            }
        });

        $this->command->info('Úspešne presunutých ' . User::count() . ' záznamov do tabuľky users.');
    }
}
