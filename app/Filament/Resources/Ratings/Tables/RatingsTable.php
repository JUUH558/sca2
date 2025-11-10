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
                TextColumn::make('zakaznik.meno') // Používame názov relácie ('zakaznik') a stĺpec z nej ('meno')
                    ->label('Meno')
                    ->sortable()
                    ->searchable(), // Môžete vyhľadávať podľa mena

                // Stĺpec pre Priezvisko Zákazníka:
                TextColumn::make('zakaznik.priezvisko')
                    ->label('Priezvisko')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('datum')
                    ->date()
                    ->sortable(),
                TextColumn::make('matka')
                    ->searchable(),
                /*                 TextColumn::make('skratka_chovu')
                    ->searchable(),
 */
                TextColumn::make('med')
                    ->numeric()
                    ->sortable(),
                // Váš nový stĺpec:
                TextColumn::make('priemerna_hodnota')
                    ->label('Priemer') // VZ = Vlastnosti Znášky, alebo podobne
                    ->sortable() // POZOR: radenie bude fungovať len pri použití Filament v2.x Query Builder
                    ->numeric(decimalPlaces: 2)
                    ->color('success'),
                    //->description('Priemer všetkých hodnotených vlastností'),
                TextColumn::make('hygienicky_test')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('varroa')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('miernost')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('rozbiehavost')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('rojivost')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('stavba_ms')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('zimovanie_pocet_uliciek')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('nozema')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('zasoby')
                    ->toggleable(isToggledHiddenByDefault: true)
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
                //EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //DeleteBulkAction::make(),
                ]),
            ]);
    }
}
