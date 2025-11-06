<?php

namespace App\Filament\Resources\Inseminators\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use App\Filament\Resources\Inseminators\InseminatorResource; // TENTO RIADOK BOL PRIDANÝ

class InseminatorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('meno')
                    ->searchable(),
                TextColumn::make('priezvisko')
                    ->searchable(),
                TextColumn::make('titul')
                    ->searchable(),
                TextColumn::make('mail')
                    ->searchable(),
                TextColumn::make('telefon')
                ->label('Telefón')
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
               EditAction::make()
                   // KĽÚČOVÁ ZMENA: PRIDANIE EditAction $action ako druhého argumentu
                    ->url(fn ($record, EditAction $action) => InseminatorResource::getUrl('edit', [
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

