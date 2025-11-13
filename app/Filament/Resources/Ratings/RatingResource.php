<?php

namespace App\Filament\Resources\Ratings;

use App\Filament\Resources\Ratings\Pages\CreateRating;
use App\Filament\Resources\Ratings\Pages\EditRating;
use App\Filament\Resources\Ratings\Pages\ListRatings;
use App\Filament\Resources\Ratings\Schemas\RatingForm;
use App\Filament\Resources\Ratings\Tables\RatingsTable;
use App\Models\Rating;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class RatingResource extends Resource
{
    protected static ?string $model = Rating::class;
    protected static string | UnitEnum | null $navigationGroup = 'Matky';
    protected static ?int $navigationSort = 3;
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

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Hodnotenie';
    protected static bool $hasTitleCaseModelLabel = false;

    public static function form(Schema $schema): Schema
    {
        return RatingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RatingsTable::configure($table);
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
            'index' => ListRatings::route('/'),
            'create' => CreateRating::route('/create'),
            'edit' => EditRating::route('/{record}/edit'),
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
            return $query
                ->where('skratka_chovu', $skratka_chovu);
        }

        // Ak nie je prihlásený, nezobrazujeme žiadne záznamy (alebo sa Filament postará o redirect)
        return $query->whereRaw('1 = 0');
    }
    public static function getModelLabel(): string
    {
        return 'Hodnotené matky';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Hodnotené matky';
    }

    public static function getNavigationLabel(): string
    {
        return 'Hodnotené matky';
    }
}
