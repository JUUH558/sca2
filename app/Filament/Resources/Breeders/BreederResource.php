<?php

namespace App\Filament\Resources\Breeders;

use App\Filament\Resources\Breeders\Pages\CreateBreeder;
use App\Filament\Resources\Breeders\Pages\EditBreeder;
use App\Filament\Resources\Breeders\Pages\ListBreeders;
use App\Filament\Resources\Breeders\Schemas\BreederForm;
use App\Filament\Resources\Breeders\Tables\BreedersTable;
use App\Models\Breeder;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

// use App\Filament\Resources\Breeders\Builder;

class BreederResource extends Resource
{

    protected static ?string $model = Breeder::class;
    protected static string | UnitEnum | null $navigationGroup = 'Chovatelia';
    protected static ?int $navigationSort = 2;
    public static function getNavigationBadge(): ?string
    {
        //return static::getModel()::count()->where('skratka_chovu', Auth::user()->skratka_chovu)->where('rok', date('y'));
        // OPRAVENÝ KÓD:
        // 1. Získaj model.
        // 2. Aplikuj filtre (where).
        // 3. Spočítaj výsledok (count()).

        $count = static::getModel()::query()
            ->where('skratka_chovu', Auth::user()->skratka_chovu)
            ->count();

        return $count > 0 ? (string) $count : null;

    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;

    protected static ?string $recordTitleAttribute = 'Chovatelia';

    public static function form(Schema $schema): Schema
    {
        return BreederForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BreedersTable::configure($table);
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
            return $query->where('skratka_chovu', $skratka_chovu)->orderBy('priezvisko','asc');
        }

        // Ak nie je prihlásený, nezobrazujeme žiadne záznamy (alebo sa Filament postará o redirect)
        return $query->whereRaw('1 = 0');
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
            'index' => ListBreeders::route('/'),
            'create' => CreateBreeder::route('/create'),
            'edit' => EditBreeder::route('/{record}/edit'),
        ];
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
        return 'Chovateľa';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Chovatelia';
    }


}

