<?php

namespace App\Filament\Resources\Queens\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class QueenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
 /*                TextInput::make('chovatel_matiek_id')
                    ->tel()
                    ->required()
                    ->numeric(),
                TextInput::make('matka_id')
                    ->required(),
 */                TextInput::make('evidencne_cislo')
                    ->required(),
                TextInput::make('mama_matky'),
                TextInput::make('otec_matky'),
                TextInput::make('matka_trudov'),
                DatePicker::make('datum_narodenia'),
                DatePicker::make('datum_inseminacie'),
                TextInput::make('inseminoval'),
                TextInput::make('imbreeding'),
                TextInput::make('linia'),
                TextInput::make('oznacenie_matky'),
                DatePicker::make('kladie_od'),
                TextInput::make('sposob_oplodnenia'),
                DatePicker::make('datum_expedicie'),
                TextInput::make('chovatel_id')
                    ->tel()
                    ->numeric(),
                TextInput::make('seria')
                    ->numeric(),
/*                 TextInput::make('chovny_ul'),
                TextInput::make('poznamka'),
                TextInput::make('CEHZ')
                    ->required(),
                TextInput::make('skratka_chovu')
                    ->required(),
                TextInput::make('rok')
                    ->required(),
                TextInput::make('https_link')
                    ->required(),
                TextInput::make('qrcode')
                    ->required(),
                Toggle::make('tlac')
                    ->required(),
                Toggle::make('editovat')
                    ->required(),
 */            ]);
    }
}
