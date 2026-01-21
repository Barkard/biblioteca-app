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
                    ->required()
                    ->numeric()
                    ->length(8)
                    ->unique(ignoreRecord: true),
                Select::make('gender')
                    ->options([
                        'female' => 'Female',
                        'male' => 'Male',
                    ])
                    ->required(),
                TextInput::make('age')
                    ->required()
                    ->numeric(),
            ]);
    }
}
