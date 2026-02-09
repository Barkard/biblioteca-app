<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('nationality')
                    ->label('Nacionalidad')
                    ->options([
                        'V' => 'Venezolano',
                        'E' => 'Extranjero',
                        'J' => 'Jurídica',
                        'G' => 'Gubernamental',
                    ])
                    ->required(),
                TextInput::make('id_user')
                    ->label('Cédula / RIF')
                    ->required(),
                TextInput::make('name')
                    ->label('Primer Nombre')
                    ->required(),
                TextInput::make('second_name')
                    ->label('Segundo Nombre')
                    ->required(),
                TextInput::make('last_name')
                    ->label('Primer Apellido')
                    ->required(),
                TextInput::make('second_last_name')
                    ->label('Segundo Apellido')
                    ->required(),
                TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->required(),
                DatePicker::make('birthdate')
                    ->label('Fecha de Nacimiento'),
                TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $operation) => $operation === 'create' && auth()->user()->role_id !== 2)
                    ->disabled(fn (string $operation) => $operation === 'create' && auth()->user()->role_id === 2)
                    ->helperText(fn (string $operation) => $operation === 'create' && auth()->user()->role_id === 2 ? 'La contraseña se generará automáticamente usando la Cédula.' : null),
                Select::make('country_code')
                    ->label('Código de País')
                    ->options([
                        '+58' => '+58 Venezuela',
                        '+57' => '+57 Colombia',
                    ])
                    ->default('+58')
                    ->selectablePlaceholder(false),
                TextInput::make('phone')
                    ->label('Teléfono')
                    ->tel(),
                Select::make('role_id')
                    ->label('Role')
                    ->relationship('role', 'name')
                    ->default(fn () => auth()->user()->role_id === 2 ? 3 : null) // Default to Reader for Staff
                    ->disabled(fn () => auth()->user()->role_id === 2) // Blocked for Staff
                    ->dehydrated() // Ensure value is sent
                    ->required(),
                DateTimePicker::make('created_at')
                    ->label('Fecha de creación')
                    ->disabled()
                    ->dehydrated(false)
                    ->visible(fn ($livewire) => isset($livewire->record) && $livewire->record),
            ]);
    }
}
