<?php

namespace App\Filament\Resources\Breeders\Pages;

use App\Filament\Resources\Breeders\BreederResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBreeders extends ListRecords
{
    protected static string $resource = BreederResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
