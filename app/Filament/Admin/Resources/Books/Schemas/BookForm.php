<?php

namespace App\Filament\Admin\Resources\Books\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Toggle::make('status')
                    ->required(),
                TextInput::make('Edition'),
                DatePicker::make('date_published'),
                Textarea::make('synopsis')
                    ->columnSpanFull(),
            ]);
    }
}
