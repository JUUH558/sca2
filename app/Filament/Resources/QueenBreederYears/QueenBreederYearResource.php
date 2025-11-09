<?php

namespace App\Filament\Resources\QueenBreederYears;

use App\Filament\Resources\QueenBreederYears\Pages\CreateQueenBreederYear;
use App\Filament\Resources\QueenBreederYears\Pages\EditQueenBreederYear;
use App\Filament\Resources\QueenBreederYears\Pages\ListQueenBreederYears;
use App\Filament\Resources\QueenBreederYears\Schemas\QueenBreederYearForm;
use App\Filament\Resources\QueenBreederYears\Tables\QueenBreederYearsTable;
use App\Models\QueenBreederYear;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class QueenBreederYearResource extends Resource
{
    protected static ?string $model = QueenBreederYear::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Chovateľ matiek rok';

    public static function form(Schema $schema): Schema
    {
        return QueenBreederYearForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QueenBreederYearsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

 /*    public static function getPages(): array
    {
        return [
            'index' => ListQueenBreederYears::route('/'),
            'create' => CreateQueenBreederYear::route('/create'),
            'edit' => EditQueenBreederYear::route('/{record}/edit'),
        ];
    }
 */
    public static function getPages(): array
    {
        // Kontrola, či existuje záznam pre aktuálneho používateľa a aktuálny rok
        $hasRecordForCurrentYear = false;

        if (Auth::check()) {
            $skratka_chovu = Auth::user()->skratka_chovu;
            $rok = date('Y');

            $hasRecordForCurrentYear = QueenBreederYear::query()
                ->where('skratka_chovu', $skratka_chovu)
                ->where('rok', $rok)
                ->exists();
        }

        $pages = [
            'index' => ListQueenBreederYears::route('/'),
            'edit' => EditQueenBreederYear::route('/{record}/edit'),
        ];

        // Ak záznam NEEXISTUJE, pridáme stránku 'create'
        if (!$hasRecordForCurrentYear) {
            $pages['create'] = CreateQueenBreederYear::route('/create');
        }

        return $pages;
    }



    public static function getEloquentQuery(): Builder
    {
        // 1. Získanie základného dopytu
        $query = parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
        $rok = date('Y');

        // 2. Získanie mena prihláseného používateľa (admina)
        // Používame globálnu funkciu \auth() pre spoľahlivé získanie prihláseného používateľa.
        // Pridávame kontrolu, či je používateľ prihlásený.
        if (Auth::check()) {
            // Predpokladáme, že meno je v stĺpci 'name' modelu User
            // $adminName = Auth::user()->name;
            $skratka_chovu = Auth::user()->skratka_chovu;

            // 3. Aplikovanie podmienky filtrovania
            // Filtrujeme, aby 'skratka_chovu' bola rovná menu prihláseného užívateľa
            return $query->where('skratka_chovu', $skratka_chovu)->where('rok', $rok);
        }

        // Ak nie je prihlásený, nezobrazujeme žiadne záznamy (alebo sa Filament postará o redirect)
        return $query->whereRaw('1 = 0');
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getModelLabel(): string
    {
        return 'Údaje o chovateľovi matiek za rok';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Údaje o chovateľovi matiek za rok';
    }

    public static function getNavigationLabel(): string
    {
        return 'Údaje o chovateľovi matiek za rok';
    }
}
