<?php

namespace App\Filament\Resources\QueenBreederYears\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class QueenBreederYearForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('CEHZ')
                    ->hidden()
                    ->required(),
                TextInput::make('skratka_chovu')
                    ->readOnly()
                    ->required(),
                TextInput::make('typ_chovu'),
                TextInput::make('rok')
                    ->readOnly()
                    ->required(),
                TextInput::make('cislo_dekretu')
                    ->label('Číslo dekrétu'),
                DatePicker::make('datum_povolenia_RVPS')
                    ->label('Dátum povolenia RVPS'),
                TextInput::make('RVPS')
                    ->label('RVPS')
                    ->required(),
                TextInput::make('chovatel_matiek_id')
                    ->hidden(),
                DateTimePicker::make('zaznam_vytvoreny')
                    ->hidden()
                    ->required(),
                DateTimePicker::make('posledna_zmena')
                    ->hidden()
                    ->required(),
            ]);
    }
}
