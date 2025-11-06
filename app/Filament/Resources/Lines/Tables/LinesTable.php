<?php

namespace App\Filament\Resources\Lines\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
USE Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use App\Filament\Resources\Lines\LineResource; // TENTO RIADOK BOL PRIDANÝ

class LinesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('meno_line')
                ->label('Línia')
                    ->searchable(),
                TextColumn::make('skratka_linie')
                ->label('Skratka')
                    ->searchable(),
                TextColumn::make('povodca_linie')
                ->label('Pôvodca')
                    ->searchable(),
                TextColumn::make('typ_line')
                ->label('Typ')
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
                TrashedFilter::make(),
            ])
            ->recordActions([
                // EditAction::make(),
                EditAction::make()
                   // KĽÚČOVÁ ZMENA: PRIDANIE EditAction $action ako druhého argumentu
                    ->url(fn ($record, EditAction $action) => LineResource::getUrl('edit', [
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
