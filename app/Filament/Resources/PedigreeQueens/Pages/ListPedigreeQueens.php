<?php

namespace App\Filament\Resources\PedigreeQueens\Pages;

use App\Filament\Resources\PedigreeQueens\PedigreeQueenResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPedigreeQueens extends ListRecords
{
    protected static string $resource = PedigreeQueenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
