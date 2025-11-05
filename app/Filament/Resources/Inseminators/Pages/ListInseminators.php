<?php

namespace App\Filament\Resources\Inseminators\Pages;

use App\Filament\Resources\Inseminators\InseminatorResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInseminators extends ListRecords
{
    protected static string $resource = InseminatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
