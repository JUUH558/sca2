<?php

namespace App\Filament\Resources\Series\Tables;

use App\Filament\Resources\Series\SerieResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table; // TENTO RIADOK BOL PRIDANÝ

class SeriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->extremePaginationLinks()
            
            ->columns([
                TextColumn::make('seria')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('CEHZ')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('rok')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('skratka_chovu')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('mama_matky')
                    ->searchable(),
                TextColumn::make('otec_matky')
                    ->searchable(),
                TextColumn::make('datum_zalozenia_serie')
                    ->toggleable()
                    ->date()
                    ->sortable(),
                TextColumn::make('datum_liahnutia_matiek')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('linia')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('prelarvovane')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('prijate')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('zavieckovane')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('vyliahnute')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('oplodnene')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('predane')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
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
                // EditAction::make(),
                EditAction::make()
                   // KĽÚČOVÁ ZMENA: PRIDANIE EditAction $action ako druhého argumentu
                    ->url(fn ($record, EditAction $action) => SerieResource::getUrl('edit', [
                        'record' => $record,
                        // Spoľahlivo získa číslo aktuálnej stránky z komponentu tabuľky
                        'page' => $action->getLivewire()->getTablePage(),
                    ])
                    ),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
