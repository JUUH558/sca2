<?php

namespace App\Filament\Resources\PedigreeQueens\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Select;
use App\Models\Line;
use Filament\Forms\Components\Textarea;

class PedigreeQueenForm
{
    public static function configure(Schema $schema): Schema
    {
        $concatenatedLabelLinia = DB::raw("CONCAT(skratka_linie, ' - ', meno_line)");

        return $schema
            ->components([
                TextInput::make('CEHZ')
                    ->label('CEHZ')
                    ->required(),
                TextInput::make('skratka_chovu')
                    ->required(),
                Toggle::make('matka_zije')
                    ->label('Matka žije')
                    ->required(),
                TextInput::make('evidencne_cislo')
                    ->label('Evidenčné číslo')
                    ->required(),
                TextInput::make('mama_matky')
                    ->required(),
                TextInput::make('otec_matky')
                    ->required(),
                TextInput::make('matka_trudov')
                    ->label('Matka trúdov')
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

                TextInput::make('oznacenie_matky')
                    ->label('Označenie matky')
                    ->required(),
                DatePicker::make('datum_narodenia')
                    ->label('Dátum narodenia')
                    ->required(),
                DatePicker::make('datum_inseminacie')
                    ->label('Dátum inseminácie'),
                TextInput::make('imbreeding')
                    ->label('Inbreeding')
                    ->numeric(),
                DatePicker::make('kladie_od'),
                TextInput::make('umiestnenie'),
                Textarea::make('poznamka')
                    ->label('Poznámka')
                    ->columnSpanFull(),
            ]);
    }
}
