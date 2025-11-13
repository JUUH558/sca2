<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
       /**
     * Kontroluje, či má používateľ prístup k tejto stránke (URL).
     *
     * @return bool
     */

   public static function canAccess(array $parameters = []): bool
    {
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        // Len používatelia s oprávnením 9 a vyšším majú prístup
        return (int) $user->opravnenie >= 9;
    }


}
