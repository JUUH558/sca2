<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('skratka_chovu')
                    ->required(),
                TextInput::make('meno')
                    ->required(),
                TextInput::make('priezvisko')
                    ->required(),
                TextInput::make('titul'),
                TextInput::make('CEHZ')
                    ->required()
                    ->label('CEHZ'),
                TextInput::make('adresa'),
                TextInput::make('mesto'),
                TextInput::make('PSC')
                    ->label('PSČ'),
                TextInput::make('telefon')
                    ->label('Telefón')
                    ->tel(),
                TextInput::make('email')
                    ->label('Email address')
                    ->label('Mailová adresa')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->password(),
                Textarea::make('poznamka')
                    ->label('Poznámka')
                    ->columnSpanFull(),
                TextInput::make('link_na_med')
                    ->label('Link na med pre QR kód'),
                Textarea::make('text_na_med')
                    ->label('Text na med pre QR kód')
                    ->columnSpanFull(),
                TextInput::make('opravnenie')
                    ->label('Oprávnenie')
                    ->required()
                    ->numeric()
                    ->default(0),
            /*                Textarea::make('two_factor_secret')
                    ->columnSpanFull(),
                Textarea::make('two_factor_recovery_codes')
                    ->columnSpanFull(),
                DateTimePicker::make('email_verified_at'),
                DateTimePicker::make('two_factor_confirmed_at'),
                //TextInput::make('podpis'),
                DateTimePicker::make('reset_token_expire_at'),
 */]);
    }
}
