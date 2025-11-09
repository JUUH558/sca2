<?php

namespace App\Filament\Resources\QueenBreederYears\Pages;

use App\Filament\Resources\QueenBreederYears\QueenBreederYearResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditQueenBreederYear extends EditRecord
{
    protected static string $resource = QueenBreederYearResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //DeleteAction::make(),
        ];
    }
}
