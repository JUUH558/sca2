<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('skratka_chovu'),
                DatePicker::make('datum_objednavky'),
                DatePicker::make('datum_splnenia'),
                DatePicker::make('datum_zrusenia'),
                TextInput::make('dovod_zrusenia')
                    ->numeric(),
                TextInput::make('linia'),
                TextInput::make('sposob_oplodnenia'),
                TextInput::make('pocet_objednanych')
                    ->numeric(),
                TextInput::make('pocet_dodanych')
                    ->numeric(),
                TextInput::make('id_zakaznika')
                    ->numeric(),
                TextInput::make('rok'),
                TextInput::make('sposob_odberu')
                    ->numeric(),
                TextInput::make('poznamka'),
            ]);
    }
}
