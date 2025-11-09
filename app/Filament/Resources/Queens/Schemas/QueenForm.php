<?php

namespace App\Filament\Resources\Queens\Schemas;

use App\Models\Breeder;
use App\Models\Inseminator;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Select;
use App\Models\PedigreeQueen;
use Illuminate\Support\Facades\Auth;
use App\Models\Serie;
use Filament\Forms\Components\Textarea;

class QueenForm
{
    public static function configure(Schema $schema): Schema
    {
        // Vytvorenie reťazca pre zobrazenie v Select komponente
        // Predpokladáme, že 'evidencne_cislo' a 'mama_matky' sú stĺpce v PedigreeQueen
        $concatenatedLabelSerie = DB::raw("CONCAT(seria, ' - ', mama_matky, ' - ',otec_matky)");
        $concatenatedLabelInseminator = DB::raw("CONCAT(titul, ' ',meno, ' ', priezvisko)");
        $concatenatedLabelBreeder = DB::raw("CONCAT(meno, ' - ', priezvisko, ' - ',mesto)");

        return $schema
            ->components([
                TextInput::make('evidencne_cislo')
                    ->label('Evidenčné číslo')
                    ->required(),
                /*                 TextInput::make('seria')
                    ->label('Séria')
                    ->numeric(),

 */

                // Select komponent pre výber Série
                Select::make('seria_select_id') // Pole pre výber ID Plemennej matky (zobrazuje sa)
                    ->label('Seria číslo - mama matky - otec matky') // Používateľsky čitateľný názov
                    ->live() // Kľúčové: Spustí aktualizáciu pri zmene hodnoty
                    ->options(
                        // Filtrovanie dopytu na model PedigreeQueen
                        Serie::query()
                            ->where('skratka_chovu', Auth::user()->skratka_chovu)
                            ->where('rok', date('Y'))
                            // Opravené: pluck musí mať kľúč (id) a hodnotu (konkatenovaný reťazec)
                            ->pluck($concatenatedLabelSerie, 'id')
                            ->toArray()
                    )
                    ->afterStateUpdated(function (?string $state, callable $set) {
                        // Kľúčové: Funkcia sa spustí po výbere hodnoty
                        if ($state) {
                            // 1. Nájdeme vybranú Plemennú Matku
                            $serie = Serie::find($state);

                            if ($serie) {
                                // 2. Aktualizujeme pole mama_matky (CEHZ/meno) - TÁTO HODNOTA SA ULOŽÍ
                                $set('mama_matky', $serie->mama_matky); // Uloží evidencne_cislo ako matku

                                // 3. Aktualizujeme pole otec_matky (CEHZ/meno) - TÁTO HODNOTA SA ULOŽÍ
                                $set('otec_matky', $serie->otec_matky); // Uloží otca

                                // 3. Aktualizujeme pole otec_matky (CEHZ/meno) - TÁTO HODNOTA SA ULOŽÍ
                                $set('matka_trudov', $serie->matka_trudov); // Uloží otca

                                // 4. Aktualizujeme pole línia - TÁTO HODNOTA SA ULOŽÍ
                                $set('linia', $serie->linia);
                            }
                        } else {
                            // Ak je Select zrušený, vyčistíme polia
                            $set('mama_matky', null);
                            $set('otec_matky', null);
                            $set('matka_trudov', null);
                            $set('linia', null);
                        }
                    })
                    ->searchable()
                    ->required(),

                TextInput::make('mama_matky')
                    ->readonly(),
                TextInput::make('otec_matky')
                    ->readonly(),
                TextInput::make('matka_trudov')
                    ->readonly()
                    ->label('Matka trúdov'),


                DatePicker::make('datum_narodenia')
                    ->label('Dátum narodenia'),
                //TextInput::make('sposob_oplodnenia')
                //    ->label('Spôsob oplodnenia'),
                Select::make('sposob_oplodnenia')
                    ->label('Spôsob oplodnenia')
                    ->options([
                        'vs' => 'Voľne spárená',
                        'ins' => 'Inseminovaná',
                        'nepl' => 'Neoplodnená',
                        'mat' => 'Matečník',
                    ])
                    ->required(),
                DatePicker::make('datum_inseminacie')
                    ->label('Dátum inseminácie'),
                //TextInput::make('inseminoval'),
                // Select komponent pre výber Série
                Select::make('inseminoval_select_id') // Pole pre výber ID Plemennej matky (zobrazuje sa)
                    ->label('Inseminoval') // Používateľsky čitateľný názov
                    ->live() // Kľúčové: Spustí aktualizáciu pri zmene hodnoty
                    ->options(
                        // Filtrovanie dopytu na model PedigreeQueen
                        Inseminator::query()
                            // Opravené: pluck musí mať kľúč (id) a hodnotu (konkatenovaný reťazec)
                            ->pluck($concatenatedLabelInseminator, 'id')
                            ->toArray()
                    )
                    ->afterStateUpdated(function (?string $state, callable $set) {
                        // Kľúčové: Funkcia sa spustí po výbere hodnoty
                        if ($state) {
                            // 1. Nájdeme vybranú Plemennú Matku
                            $inseminator = Inseminator::find($state);

                            if ($inseminator) {
                                // 2. Aktualizujeme pole mama_matky (CEHZ/meno) - TÁTO HODNOTA SA ULOŽÍ
                                //$set('mama_matky', $serie->mama_matky); // Uloží evidencne_cislo ako matku

                                // 3. Aktualizujeme pole otec_matky (CEHZ/meno) - TÁTO HODNOTA SA ULOŽÍ
                                //$set('otec_matky', $serie->otec_matky); // Uloží otca

                                // 3. Aktualizujeme pole otec_matky (CEHZ/meno) - TÁTO HODNOTA SA ULOŽÍ
                                //$set('matka_trudov', $serie->matka_trudov); // Uloží otca

                                // 4. Aktualizujeme pole línia - TÁTO HODNOTA SA ULOŽÍ
                                //$set('linia', $serie->linia);
                            }
                        } else {
                            // Ak je Select zrušený, vyčistíme polia
                            //$set('mama_matky', null);
                            //$set('otec_matky', null);
                            //$set('matka_trudov', null);
                            //$set('linia', null);
                        }
                    })
                    ->searchable()
                    ->required(),




                TextInput::make('imbreeding')
                    ->label('Inbreeding'),
                TextInput::make('linia')
                    ->readonly()
                    ->label('Línia'),
                TextInput::make('oznacenie_matky')
                    ->label('Označenie matky'),
                DatePicker::make('kladie_od'),
                DatePicker::make('datum_expedicie')
                    ->label('Dátum expedície'),
                TextInput::make('chovny_ul')
                    ->label('Chovný úľ'),
                TextInput::make('poznamka')
                    ->label('Poznámka'),
                //TextInput::make('chovatel_id')
                //    ->label('Chovateľ - zákazník')
                //    ->numeric(),
                // Select komponent pre výber Breeders
                Select::make('breeder_select_id') // Pole pre výber ID Plemennej matky (zobrazuje sa)
                    ->label('Meno priezvisko, bydlisko') // Používateľsky čitateľný názov
                    ->live() // Kľúčové: Spustí aktualizáciu pri zmene hodnoty
                    ->options(
                        // Filtrovanie dopytu na model PedigreeQueen
                        Breeder::query()
                            ->where('skratka_chovu', Auth::user()->skratka_chovu)

                            // Opravené: pluck musí mať kľúč (id) a hodnotu (konkatenovaný reťazec)
                            ->pluck($concatenatedLabelBreeder, 'id')
                            ->toArray()
                    )
                    ->afterStateUpdated(function (?string $state, callable $set) {
                        // Kľúčové: Funkcia sa spustí po výbere hodnoty
                        if ($state) {
                            // 1. Nájdeme vybranú Plemennú Matku
                            $breeder = Breeder::find($state);

                            if ($breeder) {
                                $set('zakaznik', $breeder->meno . ' ' . $breeder->priezvisko . ', ' . $breeder->mesto . ', ' . $breeder->adresa);
                            }
                        } else {
                            // Ak je Select zrušený, vyčistíme polia
                            $set('zakaznik', null);
                        }
                    })
                    ->searchable()
                    ->required(),

                Textarea::make('zakaznik')
                    ->label('Zákazník')
                    ->disabled(),

                /*                TextInput::make('CEHZ')
                    ->required(),
                TextInput::make('skratka_chovu')
                    ->required(),
                TextInput::make('rok')
                    ->required(),
                TextInput::make('https_link')
                    ->required(),
                TextInput::make('qrcode')
                    ->required(),
                Toggle::make('tlac')
                    ->required(),
                Toggle::make('editovat')
                    ->required(),
 */
            ]);
    }
}
