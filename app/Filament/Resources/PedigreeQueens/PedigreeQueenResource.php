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

class PedigreeQueenResource extends Resource
{
    protected static ?string $model = PedigreeQueen::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

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

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
