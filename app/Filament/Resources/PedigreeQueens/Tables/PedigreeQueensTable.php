<?php

namespace App\Filament\Resources\PedigreeQueens\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use App\Filament\Resources\PedigreeQueens\PedigreeQueenResource;
class PedigreeQueensTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('CEHZ')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('skratka_chovu')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('matka_zije')
                ->label('Matka žije')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('evidencne_cislo')
                ->label('Evidenčné číslo')
                    ->searchable(),
                TextColumn::make('mama_matky')
                    ->searchable(),
                TextColumn::make('otec_matky')
                    ->searchable(),
                TextColumn::make('matka_trudov')
                ->label('Matka trúdov')
                    ->searchable(),
                TextColumn::make('linia')
                ->label('Línia')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('oznacenie_matky')
                ->label('Označenie')
                    ->searchable(),
                TextColumn::make('datum_narodenia')
                ->label('Dátum narodenia')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('datum_inseminacie')
                ->label('Dátum inseminácie')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('imbreeding')
                ->label('Inbreedeng')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('kladie_od')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('umiestnenie')
                ->toggleable()
                    ->searchable(),
                TextColumn::make('poznamka')
                ->label('Poznámka')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                // EditAction::make(),
                EditAction::make()
                   // KĽÚČOVÁ ZMENA: PRIDANIE EditAction $action ako druhého argumentu
                    ->url(fn ($record, EditAction $action) => PedigreeQueenResource::getUrl('edit', [
                        'record' => $record,
                        // Spoľahlivo získa číslo aktuálnej stránky z komponentu tabuľky
                        'page' => $action->getLivewire()->getTablePage(),
                    ])
                    ),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),           ])
           ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),

                ]),
            ]);
    }
}
