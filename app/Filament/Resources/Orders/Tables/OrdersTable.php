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
                    ->label('Dátum objednávky')
                    ->date()
                    ->sortable(),
                TextColumn::make('datum_splnenia')
                    ->label('Dátum splnenia')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->date()
                    ->sortable(),
                TextColumn::make('datum_zrusenia')
                    ->label('Dátum zrušenia')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->date()
                    ->sortable(),
                TextColumn::make('dovod_zrusenia')
                    ->label('Dôvod zrušenia')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('linia_matky.meno_line') // Používame názov relácie ('zakaznik') a stĺpec z nej ('meno')
                    ->label('Línia'),
                TextColumn::make('sposob_oplodnenia')
                    ->label('Spôsob oplodnenia')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('pocet_objednanych')
                    ->label('Počet')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('pocet_dodanych')
                    ->label('Dodané')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('rok')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('sposob_odberu')
                    ->label('Spôsob odberu')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('poznamka')
                    ->label('Poznámka')
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
