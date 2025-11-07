<?php

namespace App\Filament\Resources\Series\Pages;

use App\Filament\Resources\Series\SerieResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSerie extends EditRecord
{
    protected static string $resource = SerieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //DeleteAction::make(),
        ];
    }
    // KĽÚČOVÁ ZMENA 1: Verejná vlastnosť na uloženie čísla stránky
    public ?string $page = null;

    // KĽÚČOVÁ ZMENA 2: Povie Livewire, aby túto vlastnosť čítal/zapisoval z/do URL
    protected $queryString = [
        'page' => ['except' => 1], // Zaznamenáva parameter 'page' z URL
    ];

    // TOTO JE KĽÚČOVÁ FUNKCIA pre presmerovanie po editácii
    protected function getRedirectUrl(): string
    {
        // Číslo strany najprv skúsime získať zo session/flash dát, ak existuje,
        // inak použijeme $this->page (čo by malo byť rovnako spoľahlivé).
        $targetPage = session()->get('page') ?? $this->page;

        if ($targetPage && $targetPage != 1) {
            // Presmeruje späť na stranu s uloženým číslom
            return $this->getResource()::getUrl('index', [
                'page' => $targetPage,
            ]);
        }

        // Ak parameter neexistuje alebo sme na strane 1, vráťte sa na index bez parametra
        return $this->getResource()::getUrl('index');
    }

}
