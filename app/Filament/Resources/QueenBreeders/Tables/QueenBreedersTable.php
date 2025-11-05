<?php

namespace App\Filament\Resources\QueenBreeders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

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
                    ->searchable(),
                TextColumn::make('skratka_chovu')
                    ->searchable(),
                TextColumn::make('adresa')
                    ->searchable(),
                TextColumn::make('mesto')
                    ->searchable(),
                TextColumn::make('PSC')
                    ->searchable(),
                TextColumn::make('mail')
                    ->searchable(),
                TextColumn::make('telefon')
                    ->searchable(),
                TextColumn::make('poznamka')
                    ->searchable(),
                TextColumn::make('opravnenie')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('podpis'),
                TextColumn::make('link_na_med')
                    ->searchable(),
                TextColumn::make('text_na_med')
                    ->searchable(),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('reset_token_expire_at')
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
