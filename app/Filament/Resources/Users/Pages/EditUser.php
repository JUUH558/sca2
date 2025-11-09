<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    // KĽÚČOVÁ ZMENA 1: Verejná vlastnosť na uloženie čísla stránky

    public ?string $page = null;

    // KĽÚČOVÁ ZMENA 2: Povie Livewire, aby túto vlastnosť čítal/zapisoval z/do URL
    protected $queryString = [
        'page' => ['except' => 1], // Zaznamenáva parameter 'page' z URL
    ];

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    // KĽÚČOVÁ ZMENA 3: Prepíšeme metódu, ktorá sa volá po uložení záznamu
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Po úspešnom uložení explicitne nastavíme parameter 'page' v session/stave
        // Livewire ho teraz garantovane prenesie do metódy getRedirectUrl().
        session()->flash('page', $this->page);

        return parent::handleRecordUpdate($record, $data);
    }

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
