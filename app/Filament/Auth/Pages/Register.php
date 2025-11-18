<?php

namespace App\Filament\Auth\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Auth\Pages\Register as BaseRegister;
use filament\Support\Rules\Password;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class Register extends BaseRegister
{
    /**
     * Override the form to include custom user fields (id_user, birthdate, status)
     */
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
                    ->label('Cedula de Identidad')
                    ->required()
                    ->unique($this->getUserModel()),

                TextInput::make('email')
    ->label('Correo')
    ->email()
    ->required()
    ->reactive()
    ->afterStateUpdated(function ($state) {
        $validator = Validator::make(
            ['email' => $state],
            [
                'email' => ['required', 'email', Rule::unique(User::class, 'email')],
            ]
        );

        if ($validator->fails()) {
            $message = $validator->errors()->first('email');

            // Añadimos el error a varias keys posibles para asegurar que Filament lo pinte
            $this->addError('email', $message);
            $this->addError('form.email', $message);
            $this->addError('data.email', $message);
        } else {
            // Limpiamos todas las posibles keys
            $this->resetErrorBag('email');
            $this->resetErrorBag('form.email');
            $this->resetErrorBag('data.email');
        }
    }),



                DatePicker::make('birthdate')
                    ->label('Fecha de nacimiento')
                    ->required(),

                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }

    protected function mutateFormDataBeforeRegister(array $data): array
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
