<?php

namespace App\Filament\Resources\QueenBreeders;

use App\Filament\Resources\QueenBreeders\Pages\CreateQueenBreeder;
use App\Filament\Resources\QueenBreeders\Pages\EditQueenBreeder;
use App\Filament\Resources\QueenBreeders\Pages\ListQueenBreeders;
use App\Filament\Resources\QueenBreeders\Schemas\QueenBreederForm;
use App\Filament\Resources\QueenBreeders\Tables\QueenBreedersTable;
use App\Models\QueenBreeder;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope; 

class QueenBreederResource extends Resource
{
    protected static ?string $model = QueenBreeder::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Chovatelia matiek';

    public static function form(Schema $schema): Schema
    {
        return QueenBreederForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QueenBreedersTable::configure($table);
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
            'index' => ListQueenBreeders::route('/'),
            'create' => CreateQueenBreeder::route('/create'),
            'edit' => EditQueenBreeder::route('/{record}/edit'),
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
