<?php

namespace App\Filament\Resources\Inseminators;

use App\Filament\Resources\Inseminators\Pages\CreateInseminator;
use App\Filament\Resources\Inseminators\Pages\EditInseminator;
use App\Filament\Resources\Inseminators\Pages\ListInseminators;
use App\Filament\Resources\Inseminators\Schemas\InseminatorForm;
use App\Filament\Resources\Inseminators\Tables\InseminatorsTable;
use App\Models\Inseminator;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class InseminatorResource extends Resource
{
    protected static ?string $model = Inseminator::class;
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function canViewAny(): bool
    {
        // Príklad 1: Iba ak má používateľ stĺpec 'is_admin' nastavený na true (alebo 1)
        // return Auth::user()->is_admin;

        // Príklad 2: Iba ak má používateľ stĺpec 'opravnenie' rovný 'chovatel'
        // return Auth::user()->opravnenie === 'chovatel';

        // Príklad 3: Použitie Laravel Policy (Odporúčané, ak ho máte)
        // return Auth::user()->can('viewAny', static::getModel());

        // Zvoľte príklad 2, ktorý je pravdepodobne najbližší vašej implementácii
        return Auth::user() && Auth::user()->opravnenie === 9; // Predpoklad, že 'guest' nemá vidieť
    }
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Inseminátori';

    public static function form(Schema $schema): Schema
    {
        return InseminatorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InseminatorsTable::configure($table);
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
            'index' => ListInseminators::route('/'),
            'create' => CreateInseminator::route('/create'),
            'edit' => EditInseminator::route('/{record}/edit'),
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
        return 'Inseminátor';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Inseminátori';
    }

    public static function getNavigationLabel(): string
    {
        return 'Inseminátori';
    }
}
