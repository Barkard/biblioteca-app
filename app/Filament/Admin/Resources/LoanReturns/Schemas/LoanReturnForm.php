<?php

namespace App\Filament\Admin\Resources\LoanReturns\Schemas;

use App\Models\User;
use App\Models\CopyBook;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;

class LoanReturnForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('return_date')
                    ->label('Fecha de Devolución'),
                Toggle::make('status')
                    ->label('Estado')
                    ->required(),
                Select::make('user_id')
                    ->label('Usuario')
                    ->options(function () {
                        return User::query()
                            ->orderBy('name')
                            ->get()
                            ->mapWithKeys(function (User $u) {
                                return [$u->id => $u->id_user . ' - ' . $u->name . ' ' . $u->last_name];
                            })
                            ->toArray();
                    })
                    ->searchable()
                    ->preload()
                    ->required(),
                Repeater::make('loanDetails')
                    ->relationship()
                    ->schema([
                        Select::make('copy_book_id')
                            ->label('Libro / Ejemplar')
                            ->options(function () {
                                return CopyBook::with('book')
                                    ->get()
                                    ->mapWithKeys(function ($copy) {
                                        return [$copy->id => ($copy->book->title ?? 'Sin título') . ' - ' . $copy->cota];
                                    });
                            })
                            ->searchable()
                            ->preload()
                            ->required()
                            ->disableOptionsWhenSelectedInSiblingRepeaterItems(),
                    ])
                    ->addActionLabel('Añadir otro ejemplar')
                    ->defaultItems(1)
                    ->columns(1),
            ]);
    }
}
