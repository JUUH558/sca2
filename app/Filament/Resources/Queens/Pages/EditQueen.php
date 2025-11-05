<?php

namespace App\Filament\Resources\Queens\Pages;

use App\Filament\Resources\Queens\QueenResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;

class EditQueen extends EditRecord
{
    protected static string $resource = QueenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
         ];
    }
}
