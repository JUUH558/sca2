<?php

namespace App\Filament\Resources\Queens\Pages;

use App\Filament\Resources\Queens\QueenResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditQueen extends EditRecord
{
    protected static string $resource = QueenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
