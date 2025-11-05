<?php

namespace App\Filament\Resources\PedigreeQueens\Pages;

use App\Filament\Resources\PedigreeQueens\PedigreeQueenResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditPedigreeQueen extends EditRecord
{
    protected static string $resource = PedigreeQueenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    } 
}
