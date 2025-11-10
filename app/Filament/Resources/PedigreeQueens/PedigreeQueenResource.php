<?php

namespace App\Filament\Resources\PedigreeQueens;

use App\Filament\Resources\PedigreeQueens\Pages\CreatePedigreeQueen;
use App\Filament\Resources\PedigreeQueens\Pages\EditPedigreeQueen;
use App\Filament\Resources\PedigreeQueens\Pages\ListPedigreeQueens;
use App\Filament\Resources\PedigreeQueens\Schemas\PedigreeQueenForm;
use App\Filament\Resources\PedigreeQueens\Tables\PedigreeQueensTable;
use App\Models\PedigreeQueen;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class PedigreeQueenResource extends Resource
{
    protected static ?string $model = PedigreeQueen::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static bool $hasTitleCaseModelLabel = false;

    protected static ?string $recordTitleAttribute = 'Plemenné matky';

    public static function form(Schema $schema): Schema
    {
        return PedigreeQueenForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PedigreeQueensTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPedigreeQueens::route('/'),
            'create' => CreatePedigreeQueen::route('/create'),
            'edit' => EditPedigreeQueen::route('/{record}/edit'),
        ];
    }
    // KĽÚČOVÁ ZMENA: Filtrovanie záznamov pre zoznam
    // Táto metóda definuje, aké záznamy sa vôbec zobrazia v zozname.
    public static function getEloquentQuery(): Builder
    {
        // 1. Získanie základného dopytu
        $query = parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);

        // 2. Získanie mena prihláseného používateľa (admina)
        // Používame globálnu funkciu \auth() pre spoľahlivé získanie prihláseného používateľa.
        // Pridávame kontrolu, či je používateľ prihlásený.
        if (Auth::check()) {
            // Predpokladáme, že meno je v stĺpci 'name' modelu User
            //$adminName = Auth::user()->name;
            $skratka_chovu = Auth::user()->skratka_chovu;

            // 3. Aplikovanie podmienky filtrovania
            // Filtrujeme, aby 'skratka_chovu' bola rovná menu prihláseného užívateľa
            return $query->where('skratka_chovu', $skratka_chovu)->orderByDesc('matka_zije');
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
    // preklad názvov tabuliek
    public static function getModelLabel(): string
    {
        return 'Plemenná matka';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Plemenné matky';
    }

    public static function getNavigationLabel(): string
    {
        return 'Plemenné matky';
    }
}
