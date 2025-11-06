<?php

namespace App\Filament\Resources\Lines\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('meno_line')
                    ->required(),
                TextInput::make('skratka_linie')
                    ->required(),
                TextInput::make('povodca_linie')
                    ->required(),
                TextInput::make('typ_line')
                    ->required()
                    ->numeric(),
            ]);
    } 
}
