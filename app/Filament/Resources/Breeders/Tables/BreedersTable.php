<?php

namespace App\Filament\Resources\Breeders\Tables;

use App\Filament\Resources\Breeders\BreederResource; // TENTO RIADOK BOL PRIDANÝ
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table; // Potrebujeme importovať triedu Resource!

class BreedersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('meno')
                    ->searchable(),
                TextColumn::make('priezvisko')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('skratka_chovu')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('patri_k_chovatelovi_matiek')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('titul')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('CEHZ')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('adresa')
                    ->searchable(),
                TextColumn::make('mesto')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('psc')
                    ->label('PSČ')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('telefon')
                    ->label('Telefón')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('mail')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('poznamka')
                    ->label('Poznámka')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('sposob_odberu_matiek')
                    ->label('Spôsob odberu matiek')
                    ->numeric()
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
                //
            ])
            ->recordActions([
                // EditAction::make(),
                EditAction::make()
                    // KĽÚČOVÁ ZMENA: PRIDANIE EditAction $action ako druhého argumentu
                    ->url(
                        fn($record, EditAction $action) => BreederResource::getUrl('edit', [
                            'record' => $record,
                            // Spoľahlivo získa číslo aktuálnej stránky z komponentu tabuľky
                            'page' => $action->getLivewire()->getTablePage(),
                        ])
                    ),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
