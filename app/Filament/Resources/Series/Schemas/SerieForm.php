<?php

namespace App\Filament\Resources\Series\Schemas;

use App\Models\PedigreeQueen;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // Pre prácu s reťazcami
use Illuminate\Support\Facades\Auth;

class SerieForm
{
    public static function configure(Schema $schema): Schema
    {
        // Vytvorenie reťazca pre zobrazenie v Select komponente
        // Predpokladáme, že 'evidencne_cislo' a 'mama_matky' sú stĺpce v PedigreeQueen
        $concatenatedLabel = DB::raw("CONCAT(evidencne_cislo, ' - ', mama_matky, ' úľ:',umiestnenie)");

        return $schema
            ->components([
                TextInput::make('seria')
                ->readonly()
                                    ->placeholder('Automaticky doplnené po uložení')

                    ->numeric(),

                // ZMENA 1: Select komponent s dynamicou logikou
                Select::make('mama_matky') // Toto pole ukladá ID vybranej Plemennej Matky
                    ->label('Plemenná matka (ID)') // Používateľsky čitateľný názov
                    ->live() // Kľúčové: Spustí aktualizáciu pri zmene hodnoty
                    ->options(
                        // Filtrovanie dopytu na model PedigreeQueen
                        PedigreeQueen::query()
                            ->where('skratka_chovu', Auth::user()->skratka_chovu)
                            ->where('matka_zije', 1)
                            // Opravené: pluck musí mať kľúč (id) a hodnotu (konkatenovaný reťazec)
                            ->pluck($concatenatedLabel, 'id')
                            ->toArray()
                    )
                    ->afterStateUpdated(function (?string $state, callable $set) {
                        // Kľúčové: Funkcia sa spustí po výbere hodnoty
                        if ($state) {
                            // 1. Nájdeme vybranú Plemennú Matku
                            $queen = PedigreeQueen::find($state);

                            if ($queen) {
                                // 2. Aktualizujeme pole s matkou (matka vybranej matky)
                                // Predpokladáme, že jej mama je v stĺpci 'mama_matky' (CEHZ/meno)
                                $set('mama_matky', $queen->evidencne_cislo);
                                $set('otec_matky', $queen->otec_matky);

                                // 3. Aktualizujeme pole s otcom (otec vybranej matky)
                                // Predpokladáme, že jej otec je v stĺpci 'otec_matky' (CEHZ/meno)
                                //$set('otec_matky', $queen->mama_matky);
                                $set('linia', $queen->linia);


                            }
                        } else {
                            // Ak je Select zrušený, vyčistíme polia
                            $set('mama_matky', null);
                            $set('otec_matky', null);
                            $set('linia', null);

                        }
                    })
                    ->searchable()
                    ->required(),

                // ZMENA 2: Nové read-only pole na zobrazenie Matky vybranej matky
                TextInput::make('mama_matky') // Toto pole zobrazuje Matku vybranej Plemennej Matky
                    ->label('Matka vybranej plemennej matky (CEHZ)') // Nový label
                    ->placeholder('Automaticky doplnené po výbere Plemennej matky')
                    ->readonly() // Pole je len na zobrazenie
                    //->dehydrated(false) // Hodnota sa neuloží do modelu Serie (len zobrazenie)
                    ->required(),

                // ZMENA 3: TextInput pre otca, teraz dynamicky plnený
                TextInput::make('otec_matky')
                    ->label('Otec vybranej plemennej matky (CEHZ)')
                    ->placeholder('Automaticky doplnené po výbere Plemennej matky')
                    ->readonly(), // Pole je len na zobrazenie
                    //->dehydrated(false), // Hodnota sa neuloží do modelu Serie (len zobrazenie)

                DatePicker::make('datum_zalozenia_serie')
                    ->required(),
                DatePicker::make('datum_liahnutia_matiek'),
                TextInput::make('linia')
                    ->readonly(),
                TextInput::make('prelarvovane')
                    ->numeric()
                    ->default(0),
                TextInput::make('prijate')
                    ->numeric()
                    ->default(0),
                TextInput::make('zavieckovane')
                    ->numeric()
                    ->default(0),
                TextInput::make('vyliahnute')
                    ->numeric()
                    ->default(0),
                TextInput::make('oplodnene')
                    ->numeric()
                    ->default(0),
                TextInput::make('predane')
                    ->numeric()
                    ->default(0),
            ]);
    }
}



/* <?php

namespace App\Filament\Resources\Series\Schemas;

use App\Models\PedigreeQueen;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput; // DÔLEŽITÉ: Import Select komponentu
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB; // DÔLEŽITÉ: Import pre použitie DB::raw()

class SerieForm
{
    public static function configure(Schema $schema): Schema
    {
        // Predpokladáme, že stĺpec s unikátnym označením matky je 'oznacenie_matky'
        $concatenatedLabel = DB::raw("CONCAT(evidencne_cislo, ' - ', mama_matky, ' ')");

        return $schema
            ->components([
                TextInput::make('seria')
                    // ->required()
                    ->numeric(),
                Select::make('Plemenná matka')
                    ->label('Plemenná matka') // Používateľsky čitateľný názov
                    ->relationship(name: 'mamaMatky', titleAttribute: 'id') // Definuje vzťah pre Select
                    ->options(
                        // Ručné načítanie všetkých matiek z PedigreeQueen,
                        // kde je kľúčom 'id' a hodnotou 'id' (alebo iný čitateľný stĺpec)
                        PedigreeQueen::query()
                            // Filtrovať len pre skratku chovu 'UHJ'
                            ->where('skratka_chovu', 'UHJ')
                            // Filtrovať len pre "žijúce" matky (predpokladáme stĺpec 'zijuca' s hodnotou 1)
                            ->where('matka_zije', 1)
                            // Načítanie ID ako kľúča aj hodnoty pre zobrazenie
                            ->pluck(($concatenatedLabel))
                            // ->pluck('otec_matky','otec_matky')
                            ->toArray()
                    )
                   // ->searchable() // Umožní hľadať medzi matkami
                    ->required(),

                TextInput::make('mama_matky')
                    ->required(),
                TextInput::make('otec_matky'),
                DatePicker::make('datum_zalozenia_serie')
                    ->required(),
                DatePicker::make('datum_liahnutia_matiek'),
                TextInput::make('linia')
                    ->readonly(),
                TextInput::make('prelarvovane')
                    ->numeric()
                    ->default(0),
                TextInput::make('prijate')
                    ->numeric()
                    ->default(0),
                TextInput::make('zavieckovane')
                    ->numeric()
                    ->default(0),
                TextInput::make('vyliahnute')
                    ->numeric()
                    ->default(0),
                TextInput::make('oplodnene')
                    ->numeric()
                    ->default(0),
                TextInput::make('predane')
                    ->numeric()
                    ->default(0),
            ]);
    }
}
 */
