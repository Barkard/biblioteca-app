<?php

namespace App\Filament\Admin\Resources\LoanReturns;

use App\Filament\Admin\Resources\LoanReturns\Pages\CreateLoanReturn;
use App\Filament\Admin\Resources\LoanReturns\Pages\EditLoanReturn;
use App\Filament\Admin\Resources\LoanReturns\Pages\ListLoanReturns;
use App\Filament\Admin\Resources\LoanReturns\Schemas\LoanReturnForm;
use App\Filament\Admin\Resources\LoanReturns\Tables\LoanReturnsTable;
use App\Models\LoanReturn;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LoanReturnResource extends Resource
{
    protected static ?string $model = LoanReturn::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $modelLabel = 'Préstamo/Devolución';
    protected static ?string $pluralModelLabel = 'Préstamos y Devoluciones';
    protected static ?string $navigationLabel = 'Préstamos';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return LoanReturnForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LoanReturnsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLoanReturns::route('/'),
            'create' => CreateLoanReturn::route('/create'),
            'edit' => EditLoanReturn::route('/{record}/edit'),
        ];
    }
}
