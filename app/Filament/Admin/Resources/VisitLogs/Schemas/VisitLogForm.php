<?php

namespace App\Filament\Admin\Resources\VisitLogs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VisitLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id_user')
                    ->label('Cédula')
                    ->placeholder('Ingrese la cédula del usuario')
                    ->required()
                    ->numeric()
                    ->length(8)
                    ->unique(ignoreRecord: true),
                Select::make('gender')
                    ->label('Género')
                    ->placeholder('Seleccione un género')
                    ->options([
                        'female' => 'Femenino',
                        'male' => 'Masculino',
                    ])
                    ->required(),
                TextInput::make('age')
                    ->label('Edad')
                    ->placeholder('Ingrese la edad')
                    ->required()
                    ->numeric(),
            ]);
    }
}
