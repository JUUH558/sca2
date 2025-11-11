<?php

namespace App\Filament\Resources\Ratings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class RatingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DateTimePicker::make('zapisane')
                ->label('Dátum a čas zápisu')
                    ->required(),
                TextInput::make('hodnotil')
                    ->required()
                    ->numeric(),
                DatePicker::make('datum')
                    ->required(),
                TextInput::make('matka')
                    ->required(),
                TextInput::make('skratka_chovu')
                    ->required(),
                TextInput::make('med')
                    ->numeric(),
                TextInput::make('hygienicky_test')
                    ->numeric(),
                TextInput::make('varroa')
                    ->numeric(),
                TextInput::make('miernost')
                    ->numeric(),
                TextInput::make('rozbiehavost')
                    ->numeric(),
                TextInput::make('rojivost')
                    ->numeric(),
                TextInput::make('stavba_ms')
                    ->numeric(),
                TextInput::make('zimovanie_pocet_uliciek')
                    ->numeric(),
                TextInput::make('nozema')
                    ->numeric(),
                TextInput::make('zasoby')
                    ->numeric(),
                Textarea::make('poznamka')
                    ->columnSpanFull(),
            ]);
    }
}
