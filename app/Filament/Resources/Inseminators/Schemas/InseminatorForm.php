<?php

namespace App\Filament\Resources\Inseminators\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InseminatorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('meno')
                    ->required(),
                TextInput::make('priezvisko')
                    ->required(),
                TextInput::make('titul')
                    ->required(),
                TextInput::make('mail'),
                TextInput::make('telefon')
                    ->tel(),
            ]);
    }
}
