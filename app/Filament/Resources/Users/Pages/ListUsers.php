<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        $userPermission = Auth::user() ? (int) Auth::user()->opravnenie : 0;
        if ($userPermission < 9) {
            return [];
        } else {
            return [
                CreateAction::make(),
            ];
        }
    }
}
