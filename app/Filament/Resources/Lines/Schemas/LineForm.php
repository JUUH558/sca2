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
                    ->label('Meno línie')
                    ->required(),
                TextInput::make('skratka_linie')
                    ->label('Skratka línie')
                    ->required(),
                TextInput::make('povodca_linie')
                    ->label('Pôvodca línie')
                    ->required(),
                TextInput::make('typ_line')
                    ->label('Typ línie')
                    ->required()
                    ->numeric(),
            ]);
    }
}
