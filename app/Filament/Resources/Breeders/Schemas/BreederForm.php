<?php

namespace App\Filament\Resources\Breeders\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

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
/*                 TextInput::make('skratka_chovu')
                    ->default(Auth::user()->name)
                    ->hidden(),
                TextInput::make('patri_k_chovatelovi_matiek')
                    ->default(Auth::user()->id)
                    ->hidden(),
 */                TextInput::make('titul'),
                TextInput::make('CEHZ')
                    ->label('CEHZ'),
                TextInput::make('adresa'),
                TextInput::make('mesto'),
                TextInput::make('psc')
                    ->label('PSČ'),
                TextInput::make('telefon')
                    ->label('Telefón')
                    ->tel(),
                TextInput::make('mail')->email(),
                TextInput::make('poznamka')
                    ->label('Poznámka'),
                TextInput::make('sposob_odberu_matiek')
                    ->label('Spôsob odberu matiek')
                    ->numeric(),
            ]);
    }
}
