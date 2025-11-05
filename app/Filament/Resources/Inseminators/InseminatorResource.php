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

class InseminatorResource extends Resource
{
    protected static ?string $model = Inseminator::class;

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
}
