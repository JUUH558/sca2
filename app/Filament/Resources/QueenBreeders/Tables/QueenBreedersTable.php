<?php

namespace App\Filament\Resources\QueenBreeders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use App\Filament\Resources\QueenBreeders\QueenBreederResource; // TENTO RIADOK BOL PRIDANÝ

class QueenBreedersTable
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
                TextColumn::make('CEHZ')
                ->label('CEHZ')
                    ->searchable(),
                TextColumn::make('skratka_chovu')
                    ->searchable(),
                TextColumn::make('adresa')
                    ->searchable(),
                TextColumn::make('mesto')
                    ->searchable(),
                TextColumn::make('PSC')
                ->label('PSČ')
                    ->searchable(),
                TextColumn::make('mail')
                   ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('telefon')
                ->label('Telefón')
                   ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('poznamka')
                ->label('Poznámka')
                   ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('opravnenie')
                ->label('Oprávnenie')
                   ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('podpis')
                   ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('link_na_med')
                   ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('text_na_med')
                   ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('reset_token_expire_at')
                   ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime()
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
                TrashedFilter::make(),
            ])
            ->recordActions([
                // EditAction::make(),
                EditAction::make()
                   // KĽÚČOVÁ ZMENA: PRIDANIE EditAction $action ako druhého argumentu
                    ->url(fn ($record, EditAction $action) => QueenBreederResource::getUrl('edit', [
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
