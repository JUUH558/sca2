<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('skratka_chovu')
                    ->searchable(),
                TextColumn::make('datum_objednavky')
                    ->date()
                    ->sortable(),
                TextColumn::make('datum_splnenia')
                    ->date()
                    ->sortable(),
                TextColumn::make('datum_zrusenia')
                    ->date()
                    ->sortable(),
                TextColumn::make('dovod_zrusenia')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('linia')
                    ->searchable(),
                TextColumn::make('sposob_oplodnenia')
                    ->searchable(),
                TextColumn::make('pocet_objednanych')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('pocet_dodanych')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('id_zakaznika')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('rok')
                    ->searchable(),
                TextColumn::make('sposob_odberu')
                    ->numeric()
                    ->sortable(),
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
