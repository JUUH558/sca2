<?php

namespace App\Filament\Resources\Breeders\Pages;

use App\Filament\Resources\Breeders\BreederResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateBreeder extends CreateRecord
{
    protected static string $resource = BreederResource::class;

        protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Nastavíme skratku chovu z prihláseného používateľa
        $data['skratka_chovu'] = Auth::user()->name;

        // Nastavíme ID prihláseného používateľa
        $data['patri_k_chovatelovi_matiek'] = Auth::user()->id;

        return $data;
    }

        // Nová metóda na presmerovanie s parametrami stránkovania
    protected function getRedirectUrl(): string
    {
        // Vráti odkaz na stránku 'index' a zachová pôvodné parametre GET
        return $this->getResource()::getUrl('index', [
            'tablePage' => request('tablePage')
        ]);
    }

}
