<?php

namespace App\Filament\Resources\Series\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SerieForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('seria')
                    //->required()
                    ->numeric(),
 /*                TextInput::make('CEHZ')
                    ->required(),
                TextInput::make('rok')
                    ->required(),
                TextInput::make('skratka_chovu')
                    ->required(),
 */                TextInput::make('mama_matky')
                    ->required(),
                TextInput::make('otec_matky'),
                DatePicker::make('datum_zalozenia_serie')
                    ->required(),
                DatePicker::make('datum_liahnutia_matiek')
                    ,
                TextInput::make('linia')
                ->readonly(),
                TextInput::make('prelarvovane')
                     ->numeric()
                    ->default(0),
                TextInput::make('prijate')
                   ->numeric()
                    ->default(0),
                TextInput::make('zavieckovane')
                     ->numeric()
                    ->default(0),
                TextInput::make('vyliahnute')
                    ->numeric()
                    ->default(0),
                TextInput::make('oplodnene')
                    ->numeric()
                    ->default(0),
                TextInput::make('predane')
                    ->numeric()
                    ->default(0),
            ]);
    }
}
