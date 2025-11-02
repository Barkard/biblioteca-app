<?php

namespace App\Filament\Auth\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Auth\Pages\Register as BaseRegister;

class Register extends BaseRegister
{
    /**
     * Override the form to include custom user fields (id_user, birthdate, status)
     */
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // name, email, password, passwordConfirmation come from the base implementation
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
                    ->label('Cedula de Identidad')
                    ->required()
                    ->unique($this->getUserModel()),

                $this->getEmailFormComponent(),

                DatePicker::make('birthdate')
                    ->label('Fecha de nacimiento')
                    ->required(),

                Toggle::make('status')
                    ->label('Activo')
                    ->default(true),

                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }

    /**
     * Mutate the form data before register so fields are saved correctly.
     * Keep the password handling from the base class (already hashed via dehydrate).
     *
     * @param array<string,mixed> $data
     * @return array<string,mixed>
     */
    protected function mutateFormDataBeforeRegister(array $data): array
    {
        // Ensure status is boolean and birthdate format is stored as string (Y-m-d)
        if (array_key_exists('status', $data)) {
            $data['status'] = (bool) $data['status'];
        }

        if (array_key_exists('birthdate', $data) && $data['birthdate'] instanceof \Carbon\Carbon) {
            $data['birthdate'] = $data['birthdate']->toDateString();
        }

        return $data;
    }
}
