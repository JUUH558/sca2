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

class QueenResource extends Resource
{
    protected static ?string $model = Queen::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Matky';

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

    public static function getPages(): array
    {
        return [
            'index' => ListQueens::route('/'),
            'create' => CreateQueen::route('/create'),
            'edit' => EditQueen::route('/{record}/edit'),
        ];
    }
}
