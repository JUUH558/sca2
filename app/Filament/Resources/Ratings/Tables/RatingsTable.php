<?php

namespace App\Filament\Resources\Ratings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RatingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('zapisane')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('hodnotil')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('datum')
                    ->date()
                    ->sortable(),
                TextColumn::make('matka')
                    ->searchable(),
                TextColumn::make('skratka_chovu')
                    ->searchable(),
                TextColumn::make('med')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('hygienicky_test')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('varroa')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('miernost')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('rozbiehavost')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('rojivost')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('stavba_ms')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('zimovanie_pocet_uliciek')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('nozema')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('zasoby')
                    ->numeric()
                    ->sortable(),
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
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
