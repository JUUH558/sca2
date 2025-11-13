<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use UnitEnum;


class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static string | UnitEnum | null $navigationGroup = 'Chovatelia';
    protected static ?int $navigationSort = 1;
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    protected static string|BackedEnum|null $navigationIcon = Heroicon::User;

    protected static ?string $recordTitleAttribute = 'Users';
    protected static bool $hasTitleCaseModelLabel = false;

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
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
            $opravnenie = Auth::user()->opravnenie;
            if ($opravnenie == 9) {
                // Ak je oprávnenie 9, vrátime všetky záznamy bez filtrovania
                return $query->orderBy('priezvisko', 'asc');
            } else {
                // Pokračujeme na filtrovanie nižšie


                // 3. Aplikovanie podmienky filtrovania
                // Filtrujeme, aby 'skratka_chovu' bola rovná menu prihláseného užívateľa
                return $query->where('skratka_chovu', $skratka_chovu)->orderBy('priezvisko', 'asc');
            }
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
            'index' => ListUsers::route('/'),
            'edit' => EditUser::route('/{record}/edit'),
            'create' => CreateUser::route('/create'),
        ];
    }

    /*         return [
            'index' => ListUsers::route('/'),
            'edit' => EditUser::route('/{record}/edit'),
            'create' => CreateUser::route('/create'),
         ];
 */
    // Ak opravnenie používateľa je 9 alebo vyššie, pridáme stránku na vytváranie používateľov
    /*         $opravnenie = Auth::user() ? (int) Auth::user()->opravnenie : 0;
        if ($opravnenie >= 9) {
            $pages=['create' => CreateUser::route('/create')] ;
        }
        return $pages;
 */
    public static function canCreate(): bool
    {
        // Len používatelia s oprávnením 9 a vyšším môžu vytvárať nové matky.
        $userPermission = Auth::user() ? (int) Auth::user()->opravnenie : 0;

        return $userPermission >= 9;
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
        return 'Chovateľa matiek';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Chovatelia matiek';
    }

    public static function getNavigationLabel(): string
    {
        return 'Chovatelia matiek';
    }
}
