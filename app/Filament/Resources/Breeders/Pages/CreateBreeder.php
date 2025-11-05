<?php

namespace App\Filament\Resources\Breeders\Pages;

use App\Filament\Resources\Breeders\BreederResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBreeder extends CreateRecord
{
    protected static string $resource = BreederResource::class;
        // Nová metóda na presmerovanie s parametrami stránkovania
    protected function getRedirectUrl(): string
    {
        // Vráti odkaz na stránku 'index' a zachová pôvodné parametre GET
        return $this->getResource()::getUrl('index', [
            'tablePage' => request('tablePage')
        ]);
    }

}
