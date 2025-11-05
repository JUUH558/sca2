<?php

namespace App\Filament\Resources\QueenBreeders\Pages;

use App\Filament\Resources\QueenBreeders\QueenBreederResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListQueenBreeders extends ListRecords
{
    protected static string $resource = QueenBreederResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
