<?php

namespace App\Filament\Resources\Series\Pages;

use App\Filament\Resources\Series\SerieResource;
use App\Models\Serie;
use Carbon\Carbon; // Predpokladáme, že model sa volá Serie
use Filament\Resources\Pages\CreateRecord; // Import triedy Carbon pre prácu s dátumami
use Illuminate\Support\Facades\Auth;

class CreateSerie extends CreateRecord
{
    protected static string $resource = SerieResource::class;

    /**
     * Získava nasledujúce číslo série, automaticky ho dopĺňa do formulára
     * na základe aktuálneho roka a skratky chovu.
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // 1. Nastavíme aktuálny rok
        $currentYear = Carbon::now()->year;
        $skratka_chovu = Auth::user()->name;
        $data['skratka_chovu'] = $skratka_chovu;
        $data['CEHZ'] = '149525';

        // Ak nie je stĺpec 'rok' vyplnený, doplníme ho aktuálnym rokom
        if (empty($data['rok'])) {
            $data['rok'] = $currentYear;
        }

        // 2. Kontrola, či je vybraná skratka chovu
        // Predpokladáme, že skratka chovu je v $data['skratka_chovu']
        if (empty($data['skratka_chovu'])) {
            // Ak chýba skratka chovu, nemôžeme dopočítať sériu,
            // preto by mal byť tento údaj povinný vo formulári.
            // Zatiaľ vrátime pôvodné dáta, ak chýba.
            return $data;
        }

        // 3. Vypočítame nasledujúce číslo série (poradové číslo)
        if (empty($data['seria'])) {
            // Zistíme, koľko sérií už existuje pre danú kombináciu:
            // - filter podľa 'rok' (aktuálny/zadaný)
            // - filter podľa 'skratka_chovu'
            $existingSeriesCount = Serie::where('rok', $data['rok'])
                ->where('skratka_chovu', $skratka_chovu)
                // POZNÁMKA: Predpokladám, že hľadáte poradové číslo (COUNT) a nie MAX z existujúcich čísiel
                ->count();

            // Nastavíme nasledujúce číslo série (Počet + 1)
            // Ak už existuje 5 sérií, nová bude mať číslo 6.
            $data['seria'] = $existingSeriesCount + 1;
        }
        if (empty($data['datum_liahnutia_matiek'])) {
            // Automaticky nastavíme 'linia' na 'A' pre nové série
            $startDate = Carbon::parse($data['datum_zalozenia_serie']);

            // Pripočítame 13 dní
            $hatchingDate = $startDate->addDays(12);

            // Nastavíme stĺpec pre dátum liahnutia
            $data['datum_liahnutia_matiek'] = $hatchingDate;
        }

        // POZNÁMKA: Logika pre získanie ID 'matky matiek'
        // by mala byť spracovaná vo formulári (Select komponent),
        // kde sa ID matky uloží do stĺpca 'matka_matiek_id' (alebo podobne).

        return $data;
    }

    /**
     * Nastaví presmerovanie po úspešnom vytvorení záznamu na poslednú stránku zoznamu.
     */
    protected function getRedirectUrl(): string
    {
        $currentYear = Carbon::now()->year;
        $skratka_chovu = Auth::user()->name;

        // 1. Získame celkový počet záznamov (vrátane práve vytvoreného)
        $totalRecords = Serie::where('rok', $currentYear)
            ->where('skratka_chovu', $skratka_chovu)
                // POZNÁMKA: Predpokladám, že hľadáte poradové číslo (COUNT) a nie MAX z existujúcich čísiel
            ->count();

        // 2. Nastavíme limit záznamov na stránku (Filament default je často 10)
        // Ak máte v SerieResource nastavený iný limit (napr. 25, 50), ZMEŇTE HO TU.
        //$perPage = 10;
        $perPage = (int) request('recordsPerPage',10);

        // 3. Vypočítame číslo poslednej stránky
        // Používame funkciu ceil pre zaokrúhlenie nahor
        $lastPage = (int) ceil($totalRecords / $perPage);

        // 4. Vrátime odkaz na index stránku s parametrom 'page' nastaveným na poslednú stranu.
        return $this->getResource()::getUrl('index', [
            'page' => $lastPage,
        ]);
    }
}
