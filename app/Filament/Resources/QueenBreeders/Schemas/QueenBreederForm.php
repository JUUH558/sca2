<?php

namespace App\Filament\Resources\QueenBreeders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class QueenBreederForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('meno')
                    ->required(),
                TextInput::make('priezvisko')
                    ->required(),
                TextInput::make('titul'),
                TextInput::make('CEHZ')
                    ->required(),
                TextInput::make('skratka_chovu')
                    ->required(),
                TextInput::make('adresa'),
                TextInput::make('mesto'),
                TextInput::make('PSC'),
                TextInput::make('mail'),
                TextInput::make('telefon')
                    ->tel(),
                TextInput::make('poznamka'),
                TextInput::make('password')
                    ->password(),
                TextInput::make('opravnenie')
                    ->required()
                    ->numeric(),
                //TextInput::make('podpis'),
                TextInput::make('link_na_med'),
                TextInput::make('text_na_med'),
                DateTimePicker::make('reset_token_expire_at'),
            ]);
    }
}
