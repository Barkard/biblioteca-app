<?php

namespace App\Filament\Auth\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Auth\Pages\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getNameFormComponent(),

                TextInput::make('last_name')
                    ->label('Apellido')
                    ->required(),

                Select::make('nationality')
                    ->options([
                    'V' => 'Venezolano',
                    'E' => 'Extranjero',
                    'J' => 'Juridica',
                    'G' => 'Gubernamental',
                    ])
                    ->required(),

                TextInput::make('id_user')
                    ->label('ID Usuario')
                    ->required()
                    ->unique(ignoreRecord: true),

                $this->getEmailFormComponent(),

                DatePicker::make('birthdate')
                    ->label('Fecha de nacimiento'),

                Toggle::make('status')
                    ->label('Activo'),

                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
                $this->getCurrentPasswordFormComponent(),
            ]);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (array_key_exists('status', $data)) {
            $data['status'] = (bool) $data['status'];
        }

        if (array_key_exists('birthdate', $data) && $data['birthdate'] instanceof \Carbon\Carbon) {
            $data['birthdate'] = $data['birthdate']->toDateString();
        }

        return $data;
    }
}
