<?php

namespace App\Filament\Resources\QueenBreederYears\Pages;

use App\Filament\Resources\QueenBreederYears\QueenBreederYearResource;
use App\Models\QueenBreederYear;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListQueenBreederYears extends ListRecords
{
    protected static string $resource = QueenBreederYearResource::class;

    protected function getHeaderActions(): array
    {
        $hasRecordForCurrentYear = false;

        if (Auth::check()) {
            $skratka_chovu = Auth::user()->skratka_chovu;
            $rok = date('Y');

            $hasRecordForCurrentYear = QueenBreederYear::query()
                ->where('skratka_chovu', $skratka_chovu)
                ->where('rok', $rok)
                ->exists();
        }
        if ($hasRecordForCurrentYear) {
            return [];
        }

        return [
            CreateAction::make(),
        ];
    }
}
