<?php

namespace App\Filament\Resources\PedigreeQueens\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PedigreeQueenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('CEHZ')
                    ->required(),
                TextInput::make('skratka_chovu')
                    ->required(),
                Toggle::make('matka_zije')
                    ->required(),
                TextInput::make('evidencne_cislo')
                    ->required(),
                TextInput::make('mama_matky')
                    ->required(),
                TextInput::make('otec_matky')
                    ->required(),
                TextInput::make('matka_trudov'),
                TextInput::make('linia')
                    ->required(),
                TextInput::make('oznacenie_matky')
                    ->required(),
                DatePicker::make('datum_narodenia'),
                DatePicker::make('datum_inseminacie'),
                TextInput::make('imbreeding'),
                DatePicker::make('kladie_od'),
                TextInput::make('umiestnenie'),
                TextInput::make('poznamka'),
            ]);
    }
}
