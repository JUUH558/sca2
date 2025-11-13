<?php

namespace App\Filament\Resources\Lines;

use App\Filament\Resources\Lines\Pages\CreateLine;
use App\Filament\Resources\Lines\Pages\EditLine;
use App\Filament\Resources\Lines\Pages\ListLines;
use App\Filament\Resources\Lines\Schemas\LineForm;
use App\Filament\Resources\Lines\Tables\LinesTable;
use App\Models\Line;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class LineResource extends Resource
{
    protected static ?string $model = Line::class;
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
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

    protected static ?string $recordTitleAttribute = 'Línie';

    public static function form(Schema $schema): Schema
    {
        return LineForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LinesTable::configure($table);
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
            'index' => ListLines::route('/'),
            'create' => CreateLine::route('/create'),
            'edit' => EditLine::route('/{record}/edit'),
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
        return 'Línia';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Línie';
    }

    public static function getNavigationLabel(): string
    {
        return 'Línie';
    }
}
