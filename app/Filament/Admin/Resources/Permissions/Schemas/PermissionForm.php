<?php

namespace App\Filament\Admin\Resources\Permissions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PermissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Toggle::make('create')
                    ->required(),
                Toggle::make('read')
                    ->required(),
                Toggle::make('update')
                    ->required(),
                Toggle::make('delete')
                    ->required(),
                Select::make('role_id')
                    ->label('Permiso para la función de rol')
                    ->relationship('role', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('module_id')
                    ->label('Permiso para el módulo')
                    ->relationship('module', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }
}
