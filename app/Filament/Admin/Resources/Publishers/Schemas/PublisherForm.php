<?php

namespace App\Filament\Admin\Resources\Publishers\Schemas;

use App\Models\Publisher;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class PublisherForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->validationMessages([
                        'required' => 'El nombre de esta Editorial es obligatorio.',
                        'unique' => 'Esta Editorial ya está registrado. Por favor, elige otro.',
                        'maxLength' => 'Haz excedido el numero :max de caracteres.',
                    ]),
            ]);
    }
}
