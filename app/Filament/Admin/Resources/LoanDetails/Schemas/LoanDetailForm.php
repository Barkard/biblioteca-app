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
                    ->label('Estado')
                    ->required(),
                DatePicker::make('return_date')
                    ->label('Fecha de Devolución'),
                Select::make('copy_book_id')
                    ->label('Ejemplar')
                    ->relationship('copyBook', 'cota')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('loan_return_id')
                    ->label('Préstamo')
                    ->relationship('loanReturn', 'id')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }
}
