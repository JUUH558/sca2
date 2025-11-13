<?php

namespace App\Filament\Resources\Queens;

use App\Filament\Resources\Queens\Pages\CreateQueen;
use App\Filament\Resources\Queens\Pages\EditQueen;
use App\Filament\Resources\Queens\Pages\ListQueens;
use App\Filament\Resources\Queens\Schemas\QueenForm;
use App\Filament\Resources\Queens\Tables\QueensTable;
use App\Models\Queen;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use UnitEnum;



class QueenResource extends Resource
{
    protected static ?string $model = Queen::class;
    protected static string | UnitEnum | null $navigationGroup = 'Matky';
    public static function getNavigationBadge(): ?string
    {
        //return static::getModel()::count()->where('skratka_chovu', Auth::user()->skratka_chovu)->where('rok', date('y'));
        // OPRAVENÝ KÓD:
        // 1. Získaj model.
        // 2. Aplikuj filtre (where).
        // 3. Spočítaj výsledok (count()).

        $count = static::getModel()::query()
            ->where('skratka_chovu', Auth::user()->skratka_chovu)
            ->where('rok', date('y'))
            ->count();

        return $count > 0 ? (string) $count : null;
    }
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Cog6Tooth;
    //use BackedEnum;

    //protected static string | BackedEnum | null $activeNavigationIcon = 'heroicon-cog6-tooth-solid';

    protected static bool $hasTitleCaseModelLabel = false;
    //protected static ?int $navigationSort = 9;

    protected static ?string $recordTitleAttribute = 'Matky';
    // Nastaví Matky ako prvú položku v menu
    protected static ?int $navigationSort = 1;
    public static function form(Schema $schema): Schema
    {
        return QueenForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QueensTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
/*     public static function canCreate(): bool
    {
        // Len používatelia s oprávnením 9 a vyšším môžu vytvárať nové matky.
        $userPermission = Auth::user() ? (int) Auth::user()->opravnenie : 0;

        return $userPermission >= 9;
    }
 */
    public static function getPages(): array
    {        $userPermission = Auth::user() ? (int) Auth::user()->opravnenie : 0;
        $opravnenie = $userPermission;
        if ($opravnenie < 9) {
            return [
                'index' => ListQueens::route('/'),
                'create' => CreateQueen::route('/create'),
                'edit' => EditQueen::route('/{record}/edit'),

            ];
        } else {
            return [
                'index' => ListQueens::route('/'),
                'edit' => EditQueen::route('/{record}/edit'),

            ];
        }
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
        $rok = date('y');

        // 2. Získanie mena prihláseného používateľa (admina)
        // Používame globálnu funkciu \auth() pre spoľahlivé získanie prihláseného používateľa.
        // Pridávame kontrolu, či je používateľ prihlásený.
        if (Auth::check()) {
            // Predpokladáme, že meno je v stĺpci 'name' modelu User
            //$adminName = Auth::user()->name;
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

    // preklad názvov tabuliek
    public static function getModelLabel(): string
    {
        return 'Včelia matka';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Včelie matky';
    }

    public static function getNavigationLabel(): string
    {
        return 'Včelie matky';
    }
}
