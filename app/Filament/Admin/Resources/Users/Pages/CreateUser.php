<?php

namespace App\Filament\Admin\Resources\Users\Pages;

use App\Filament\Admin\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Si el usuario actual es Staff (ID 2), la contraseña es la cédula (id_user)
        if (auth()->user()->role_id === 2) {
            $data['password'] = $data['id_user'];
        }
        
        return $data;
    }
}
