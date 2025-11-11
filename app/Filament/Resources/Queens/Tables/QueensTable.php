<?php

namespace App\Filament\Resources\Queens\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\EditBulkAction; // <-- TOTO CHÝBA!

//use Filament\Tables\Actions\BulkActionGroup; // Pre zoskupenie akcií
use Filament\Actions\BulkAction;     // <-- Generická hromadná akcia (Použijeme ju namiesto EditBulkAction)
//use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Forms\Components\Select;       // Potrebné pre formulár
use Illuminate\Support\Collection;          // Potrebné pre metódu action()
use Filament\Forms\Form;                    // Potrebné pre formulár
use Filament\Forms\Components\TextInput;   // Potrebné pre textové vstupy
use Filament\Forms\Components\DatePicker; // Potrebné pre výber dátumu
use App\Models\Serie;
use App\Models\Breeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QueensTable
{
    public static function configure(Table $table): Table
    {
        $concatenatedLabelSerie = DB::raw("CONCAT(seria, ' - ', mama_matky, ' - ',otec_matky)");
        $concatenatedLabelInseminator = DB::raw("CONCAT(titul, ' ',meno, ' ', priezvisko)");
        $concatenatedLabelBreeder = DB::raw("CONCAT(meno, ' ', priezvisko, ', ', mesto,', ', adresa)");

        return $table
            ->columns([
                /*                 TextColumn::make('chovatel_matiek_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('matka_id')
                    ->searchable(),
 */
                TextColumn::make('evidencne_cislo')
                    ->label('Evidenčné číslo')
                    ->searchable(),
                TextColumn::make('mama_matky')
                    ->searchable(),
                TextColumn::make('otec_matky')
                    ->searchable(),
                TextColumn::make('matka_trudov')
                    ->label('Matka trúdov')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('datum_narodenia')
                    ->label('Dátum narodenia')
                    ->date('d.m.Y')
                    ->sortable(),
                TextColumn::make('datum_inseminacie')
                    ->label('Dátum inseminácie')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->date('d.m.Y')
                    ->sortable(),
                TextColumn::make('inseminoval')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('imbreeding')
                    ->label('Inbreeding')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('linia')
                    ->label('Línia')
                    ->searchable(),
                TextColumn::make('oznacenie_matky')
                    ->label('Označenie')
                    ->searchable(),
                TextColumn::make('kladie_od')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->date('d.m.Y')
                    ->sortable(),
                TextColumn::make('sposob_oplodnenia')
                    ->label('Spôsob oplodnenia')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('datum_expedicie')
                    ->label('Dátum expedície')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->date('d.m.Y')
                    ->sortable(),
                TextColumn::make('chovatel_id')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('seria')
                    ->label('Séria')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('chovny_ul')
                    ->label('Chovný úľ')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('poznamka')
                    ->label('Poznámka')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('CEHZ')
                    ->label('CEHZ')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('skratka_chovu')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('rok')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('https_link')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                /*                 TextColumn::make('qrcode')
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('tlac')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                IconColumn::make('editovat')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
 */
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // PÔVODNÝ KÓD S CHYBOU: EditBulkAction::make(),

                    // NOVÝ KÓD: Vlastná hromadná akcia pre úpravu
                    BulkAction::make('hromadna_uprava')
                        ->label('Hromadná úprava matiek')
                        ->icon('heroicon-o-pencil-square')
                        ->color('primary')
                        // Definujte polia pre hromadnú úpravu
                        ->schema([
                            // Príklad: Úprava spôsobu oplodnenia
                            // Select komponent pre výber Série
                            Select::make('seria') // Pole pre výber ID Plemennej matky (zobrazuje sa)
                                ->label('Seria číslo - mama matky - otec matky') // Používateľsky čitateľný názov
                                ->live() // Kľúčové: Spustí aktualizáciu pri zmene hodnoty
                                ->options(
                                    // Filtrovanie dopytu na model PedigreeQueen
                                    Serie::query()
                                        ->where('skratka_chovu', Auth::user()->skratka_chovu)
                                        ->where('rok', date('Y'))
                                        // Opravené: pluck musí mať kľúč (id) a hodnotu (konkatenovaný reťazec)
                                        ->pluck($concatenatedLabelSerie, 'id')
                                        ->toArray()
                                )
                                ->afterStateUpdated(function (?string $state, callable $set) {
                                    // Kľúčové: Funkcia sa spustí po výbere hodnoty
                                    if ($state) {
                                        // 1. Nájdeme vybranú Plemennú Matku
                                        $serie = Serie::find($state);

                                        if ($serie) {
                                            // 2. Aktualizujeme pole mama_matky (CEHZ/meno) - TÁTO HODNOTA SA ULOŽÍ
                                            $set('mama_matky', $serie->mama_matky); // Uloží evidencne_cislo ako matku

                                            // 3. Aktualizujeme pole otec_matky (CEHZ/meno) - TÁTO HODNOTA SA ULOŽÍ
                                            $set('otec_matky', $serie->otec_matky); // Uloží otca

                                            // 3. Aktualizujeme pole otec_matky (CEHZ/meno) - TÁTO HODNOTA SA ULOŽÍ
                                            $set('matka_trudov', $serie->matka_trudov); // Uloží otca

                                            // 4. Aktualizujeme pole línia - TÁTO HODNOTA SA ULOŽÍ
                                            $set('linia', $serie->linia);
                                        }
                                    } else {
                                        // Ak je Select zrušený, vyčistíme polia
                                        $set('mama_matky', null);
                                        $set('otec_matky', null);
                                        $set('matka_trudov', null);
                                        $set('linia', null);
                                    }
                                })
                                ->required(),

                            TextInput::make('mama_matky')
                                ->readonly(),
                            TextInput::make('otec_matky')
                                ->readonly(),
                            TextInput::make('matka_trudov')
                                ->readonly()
                                ->label('Matka trúdov'),


                            DatePicker::make('datum_narodenia')
                                ->label('Dátum narodenia'),
                            //TextInput::make('sposob_oplodnenia')
                            //    ->label('Spôsob oplodnenia'),
                            Select::make('sposob_oplodnenia')
                                ->label('Spôsob oplodnenia')
                                ->options([
                                    'vs' => 'Voľne spárená',
                                    'ins' => 'Inseminovaná',
                                    'nepl' => 'Neoplodnená',
                                    'mat' => 'Matečník',
                                ]),
                            DatePicker::make('kladie_od'),
                            DatePicker::make('datum_expedicie')
                                ->label('Dátum expedície'),
                            Select::make('chovatel_id') // Pole pre výber ID Plemennej matky (zobrazuje sa)
                                ->label('Meno, priezvisko a bydlisko zákazníka') // Používateľsky čitateľný názov
                                ->live() // Kľúčové: Spustí aktualizáciu pri zmene hodnoty
                                ->options(
                                    // Filtrovanie dopytu na model PedigreeQueen
                                    Breeder::query()
                                        ->where('skratka_chovu', Auth::user()->skratka_chovu)

                                        // Opravené: pluck musí mať kľúč (id) a hodnotu (konkatenovaný reťazec)
                                        ->pluck($concatenatedLabelBreeder, 'id')
                                        ->toArray()
                                ),
                        ])
                        // Logika, ktorá sa vykoná
                        /**
                         * @param \Illuminate\Database\Eloquent\Collection|\App\Models\Queen[] $records
                         * @param array<string,mixed> $data
                         */
                        ->action(function (Collection $records, array $data) {
                            foreach ($records as /** @var Queen */ $record) {
                                $updates = [];
                                foreach ($data as $key => $value) {
                                    // Aktualizujeme len tie stĺpce, kde bola zadaná nová hodnota
                                    if ($value !== null) {
                                        $updates[$key] = $value;
                                    }
                                }
                                if (!empty($updates)) {
                                    $record->update($updates);
                                }
                            }

                            \Filament\Notifications\Notification::make()
                                ->title('Vybrané matky boli úspešne upravené.')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(), // Zruší výber po akcii

                    //DeleteBulkAction::make(),
                ]),

            ]);
    }
}
