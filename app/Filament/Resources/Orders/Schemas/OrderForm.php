<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Select;
use App\Models\Breeder;
use Illuminate\Support\Facades\Auth;
use App\Models\Line;
use Filament\Forms\Components\Textarea;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        $concatenatedLabelBreeder = DB::raw("CONCAT(meno, ' ', priezvisko, ', ', mesto,', ', adresa)");
        $concatenatedLabelLinia = DB::raw("CONCAT(skratka_linie, ' - ', meno_line)");

        return $schema
            ->components([
                TextInput::make('skratka_chovu')
                    ->default(Auth::user()->skratka_chovu)
                    ->readOnly(),
                Select::make('id_zakaznika') // Pole pre výber ID Plemennej matky (zobrazuje sa)
                    ->label('Meno, priezvisko a bydlisko zákazníka') // Používateľsky čitateľný názov
                    ->live() // Kľúčové: Spustí aktualizáciu pri zmene hodnoty
                    ->options(
                        // Filtrovanie dopytu na model PedigreeQueen
                        Breeder::query()
                            ->where('skratka_chovu', Auth::user()->skratka_chovu)

                            // Opravené: pluck musí mať kľúč (id) a hodnotu (konkatenovaný reťazec)
                            ->pluck($concatenatedLabelBreeder, 'id')
                            ->toArray()
                    )
                    ->searchable()
                    ->required(),
                Select::make('linia') // Toto pole ukladá ID vybranej Plemennej Matky
                    ->label('Línia') // Používateľsky čitateľný názov
                    ->live() // Kľúčové: Spustí aktualizáciu pri zmene hodnoty
                    ->options(
                        // Filtrovanie dopytu na model PedigreeQueen
                        Line::query()
                            // Opravené: pluck musí mať kľúč (id) a hodnotu (konkatenovaný reťazec)
                            ->pluck($concatenatedLabelLinia, 'id')
                            ->toArray()
                    )

                    ->searchable()
                    ->required(),
                Select::make('sposob_oplodnenia')
                    ->label('Spôsob oplodnenia')
                    ->options([
                        'vs' => 'Voľne spárená',
                        'ins' => 'Inseminovaná',
                        'nepl' => 'Neoplodnená',
                        'mat' => 'Matečník',
                    ])
                    ->default('vs')
                    ->required(),
                TextInput::make('pocet_objednanych')
                    ->label('Počet objednaných')
                    ->required()
                    ->numeric(),
                /*                 TextInput::make('id_zakaznika')
                    ->numeric(),
 */
                TextInput::make('rok')
                    ->required()
                    ->default(date('Y'))
                    ->numeric(),
                DatePicker::make('datum_objednavky')
                    ->required()
                    ->default(now())
                    ->label('Dátum objednávky'),
                Select::make('sposob_odberu')
                    ->label('Spôsob odberu')
                    ->options([
                        '0' => 'Osobne',
                        '1' => 'Na poštu',
                        '2' => 'Na adresu',
                    ])
                    ->default('0')
                    ->required(),
                TextInput::make('pocet_dodanych')
                    ->label('Počet dodaných')
                    ->numeric(),
                DatePicker::make('datum_splnenia')
                    ->label('Dátum splnenia'),
                DatePicker::make('datum_zrusenia')
                    ->label('Dátum zrušenia'),
                TextInput::make('dovod_zrusenia')
                    ->label('Dôvod zrušenia')
                    ->numeric(),
                /*                 TextInput::make('linia')
                    ->label('Línia'),
                TextInput::make('sposob_oplodnenia')
                    ->label('Spôsob oplodnenia'),
 */
                /*                 TextInput::make('sposob_odberu')
                    ->label('Spôsob odberu')
                    ->numeric(),
 */
                Textarea::make('poznamka')
                    ->label('Poznámka')
                    ->columnSpanFull(),
            ]);
    }
}
