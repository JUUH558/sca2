<?php

namespace App\Filament\Resources\Queens\Pages;

use App\Filament\Resources\Queens\QueenResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use App\Models\Breeder;


class EditQueen extends EditRecord
{
    protected static string $resource = QueenResource::class;
/*     protected function afterFill(): void
    {
        $state = $this->form->getState('chovatel_id');
        // Runs after the form fields are populated from the database.
                        if ($state) {
                            // 1. Nájdeme vybranú Plemennú Matku
                            $breeder = Breeder::find($state);

                            if ($breeder) {
                                $set('zakaznik', $breeder->meno . ' ' . $breeder->priezvisko . ', ' . $breeder->mesto . ', ' . $breeder->adresa);
                            }
                        } else {
                            // Ak je Select zrušený, vyčistíme polia
                            $set('zakaznik', null);
                        }
    }
 */
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
