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
                    ->label('Dátum hodnotenia')
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
                    ->label('Hygienický test')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('varroa')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('miernost')
                    ->label('Miernosť')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('rozbiehavost')
                    ->label('Rozbiehavosť')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('rojivost')
                    ->label('Rojivosť')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('stavba_ms')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('zimovanie_pocet_uliciek')
                    ->label('Zimovanie (počet uličiek)')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('nozema')
                    ->label('Nózema')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('zasoby')
                    ->label('Zásoby')
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
