<?php

namespace App\Filament\Resources\Breeders\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BreederForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('meno')
                    ->required(),
                TextInput::make('priezvisko')
                    ->required(),
                TextInput::make('skratka_chovu')
                    ->required(),
                TextInput::make('patri_k_chovatelovi_matiek')
                    ->required()
                    ->numeric()
                    ->rules(['integer']),
                TextInput::make('titul'),
                TextInput::make('CEHZ'),
                TextInput::make('adresa'),
                TextInput::make('mesto'),
                TextInput::make('psc'),
                TextInput::make('telefon')
                    ->tel(),
                TextInput::make('mail')->email(),
                TextInput::make('poznamka'),
                TextInput::make('sposob_odberu_matiek')
                    ->numeric(),
            ]);
    }
}
