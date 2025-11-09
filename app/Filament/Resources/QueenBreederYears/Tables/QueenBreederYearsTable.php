<?php

namespace App\Filament\Resources\QueenBreederYears\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class QueenBreederYearsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('CEHZ')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('skratka_chovu')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('typ_chovu')
                    ->searchable(),
                TextColumn::make('rok')
                    ->searchable(),
                TextColumn::make('datum_povolenia_RVPS')
                    ->label('Dátum povolenia RVPS')
                    ->date('d.m.Y'),
                TextColumn::make('cislo_dekretu')
                    ->label('Číslo dekrétu')
                    ->searchable(),
                TextColumn::make('RVPS')
                    ->label('RVPS')
                    ->searchable(),
                TextColumn::make('chovatel_matiek_id')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric(),
                TextColumn::make('zaznam_vytvoreny')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime(),
                TextColumn::make('posledna_zmena')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                //BulkActionGroup::make([
                //    DeleteBulkAction::make(),
                //]),
            ]);
    }
}
