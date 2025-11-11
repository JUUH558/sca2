<?php

namespace App\Filament\Resources\Orders;

use App\Filament\Resources\Orders\Pages\CreateOrder;
use App\Filament\Resources\Orders\Pages\EditOrder;
use App\Filament\Resources\Orders\Pages\ListOrders;
use App\Filament\Resources\Orders\Schemas\OrderForm;
use App\Filament\Resources\Orders\Tables\OrdersTable;
use App\Models\Order;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static bool $hasTitleCaseModelLabel = false;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Objednávky';

    public static function form(Schema $schema): Schema
    {
        return OrderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrdersTable::configure($table);
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
            'index' => ListOrders::route('/'),
            'create' => CreateOrder::route('/create'),
            'edit' => EditOrder::route('/{record}/edit'),
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
                ->where('skratka_chovu', $skratka_chovu)
                ->orderBy('datum_objednavky', 'asc')
                ->where('rok', date('Y'));
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
        return 'Objednávku';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Objednávky';
    }

    public static function getNavigationLabel(): string
    {
        return 'Objednávky';
    }
}
