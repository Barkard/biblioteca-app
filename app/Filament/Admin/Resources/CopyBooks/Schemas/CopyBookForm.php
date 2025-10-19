<?php

namespace App\Filament\Admin\Resources\CopyBooks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CopyBookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('cota')
                    ->required(),
                Toggle::make('status')
                    ->required(),
            ]);
    }
}
