<?php

namespace App\Filament\Resources\PedigreeQueens\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class PedigreeQueensTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('CEHZ')
                    ->searchable(),
                TextColumn::make('skratka_chovu')
                    ->searchable(),
                IconColumn::make('matka_zije')
                    ->boolean(),
                TextColumn::make('evidencne_cislo')
                    ->searchable(),
                TextColumn::make('mama_matky')
                    ->searchable(),
                TextColumn::make('otec_matky')
                    ->searchable(),
                TextColumn::make('matka_trudov')
                    ->searchable(),
                TextColumn::make('linia')
                    ->searchable(),
                TextColumn::make('oznacenie_matky')
                    ->searchable(),
                TextColumn::make('datum_narodenia')
                    ->date()
                    ->sortable(),
                TextColumn::make('datum_inseminacie')
                    ->date()
                    ->sortable(),
                TextColumn::make('imbreeding')
                    ->searchable(),
                TextColumn::make('kladie_od')
                    ->date()
                    ->sortable(),
                TextColumn::make('umiestnenie')
                    ->searchable(),
                TextColumn::make('poznamka')
                    ->searchable(),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
