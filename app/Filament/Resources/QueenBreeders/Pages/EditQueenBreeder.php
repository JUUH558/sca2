<?php

namespace App\Filament\Resources\QueenBreeders\Pages;

use App\Filament\Resources\QueenBreeders\QueenBreederResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditQueenBreeder extends EditRecord
{
    protected static string $resource = QueenBreederResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    } 
}
