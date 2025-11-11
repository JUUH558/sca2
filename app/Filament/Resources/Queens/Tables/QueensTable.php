<?php

namespace App\Filament\Resources\Queens\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class QueensTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                /*                 TextColumn::make('chovatel_matiek_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('matka_id')
                    ->searchable(),
 */ TextColumn::make('evidencne_cislo')
                    ->label('Evidenčné číslo')
                    ->searchable(),
                TextColumn::make('mama_matky')
                    ->searchable(),
                TextColumn::make('otec_matky')
                    ->searchable(),
                TextColumn::make('matka_trudov')
                    ->label('Matka trúdov')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('datum_narodenia')
                    ->label('Dátum narodenia')
                    ->date('d.m.Y')
                    ->sortable(),
                TextColumn::make('datum_inseminacie')
                    ->label('Dátum inseminácie')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->date('d.m.Y')
                    ->sortable(),
                TextColumn::make('inseminoval')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('imbreeding')
                    ->label('Inbreeding')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('linia')
                    ->label('Línia')
                    ->searchable(),
                TextColumn::make('oznacenie_matky')
                    ->label('Označenie')
                    ->searchable(),
                TextColumn::make('kladie_od')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->date('d.m.Y')
                    ->sortable(),
                TextColumn::make('sposob_oplodnenia')
                    ->label('Spôsob oplodnenia')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('datum_expedicie')
                    ->label('Dátum expedície')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->date('d.m.Y')
                    ->sortable(),
                TextColumn::make('chovatel_id')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('seria')
                    ->label('Séria')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('chovny_ul')
                    ->label('Chovný úľ')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('poznamka')
                    ->label('Poznámka')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('CEHZ')
                    ->label('CEHZ')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('skratka_chovu')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('rok')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('https_link')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                /*                 TextColumn::make('qrcode')
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('tlac')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                IconColumn::make('editovat')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
 */ TextColumn::make('created_at')
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
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
