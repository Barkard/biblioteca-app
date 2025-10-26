<?php

namespace App\Filament\Admin\Resources\LoanDetails\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class LoanDetailForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Toggle::make('status')
                    ->required(),
                DatePicker::make('return_date'),
                Select::make('copy_book_id')
                    ->label('Copia')
                    ->relationship('copyBook', 'cota')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('loan_return_id')
                    ->label('Devolución')
                    ->relationship('loanReturn', 'id')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }
}
