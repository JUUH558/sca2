<?php

namespace App\Filament\Resources\Queens\Pages;

use App\Filament\Resources\Queens\QueenResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListQueens extends ListRecords
{
    protected static string $resource = QueenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
