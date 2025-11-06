<?php

namespace App\Filament\Resources\Inseminators\Pages;

use App\Filament\Resources\Inseminators\InseminatorResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;


class EditInseminator extends EditRecord
{
    protected static string $resource = InseminatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
