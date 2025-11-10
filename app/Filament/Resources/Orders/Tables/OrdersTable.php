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
                /*                 TextColumn::make('skratka_chovu')
                    ->searchable(),
 */
                TextColumn::make('zakaznik.meno') // Používame názov relácie ('zakaznik') a stĺpec z nej ('meno')
                    ->label('Meno')
                    ->sortable()
                    ->searchable(), // Môžete vyhľadávať podľa mena

                // Stĺpec pre Priezvisko Zákazníka:
                TextColumn::make('zakaznik.priezvisko')
                    ->label('Priezvisko')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('datum_objednavky')
                    ->date()
                    ->sortable(),
                TextColumn::make('datum_splnenia')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->date()
                    ->sortable(),
                TextColumn::make('datum_zrusenia')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->date()
                    ->sortable(),
                TextColumn::make('dovod_zrusenia')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('linia_matky.meno_line') // Používame názov relácie ('zakaznik') a stĺpec z nej ('meno')
                    ->label('Línia'),
                TextColumn::make('sposob_oplodnenia')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('pocet_objednanych')
                    ->label('Počet')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('pocet_dodanych')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('rok')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('sposob_odberu')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('poznamka')
                    ->toggleable(isToggledHiddenByDefault: true)
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
