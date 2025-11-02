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
                TextInput::make('name')
                    ->required(),
                TextInput::make('last_name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DatePicker::make('birthdate'),
                TextInput::make('password')
                ->password()
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
                    ->label('Cedula / Rif')
                    ->required(),
                Toggle::make('status')
                    ->required(),
                DateTimePicker::make('created_at')
                    ->label('Fecha de creación')
                    ->disabled()
                    ->dehydrated(false)
                    ->visible(fn ($livewire) => isset($livewire->record) && $livewire->record),
            ]);
    }
}
