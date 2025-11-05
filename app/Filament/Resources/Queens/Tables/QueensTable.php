<?php

namespace App\Filament\Resources\Queens\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class QueensTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                /*                TextColumn::make('chovatel_matiek_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('matka_id')
                    ->searchable(),
 */ TextColumn::make('evidencne_cislo')
                    ->searchable(),
                TextColumn::make('mama_matky')
                    ->searchable(),
                TextColumn::make('otec_matky')
                    ->searchable(),
                TextColumn::make('matka_trudov')
                    ->searchable(),
                TextColumn::make('datum_narodenia')
                    ->date()
                    ->sortable(),
                /*                TextColumn::make('datum_inseminacie')
                    ->date()
                    ->sortable(),
                TextColumn::make('inseminoval')
                    ->searchable(),
                TextColumn::make('imbreeding')
                    ->searchable(),
 */ TextColumn::make('linia')
                    ->searchable(),
                TextColumn::make('oznacenie_matky')
                    ->searchable(),
                TextColumn::make('kladie_od')
                    ->date()
                    ->sortable(),
                TextColumn::make('sposob_oplodnenia')
                    ->searchable(),
                TextColumn::make('datum_expedicie')
                    ->date()
                    ->sortable(),
                TextColumn::make('chovatel_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('seria')
                    ->numeric()
                    ->sortable(),
            /*                TextColumn::make('chovny_ul')
                    ->searchable(),
                TextColumn::make('poznamka')
                    ->searchable(),
                TextColumn::make('CEHZ')
                    ->searchable(),
                TextColumn::make('skratka_chovu')
                    ->searchable(),
                TextColumn::make('rok')
                    ->searchable(),
 */ /*                 TextColumn::make('https_link')
                    ->searchable(),
                TextColumn::make('qrcode'),
                IconColumn::make('tlac')
                    ->boolean(),
                IconColumn::make('editovat')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
 */])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
