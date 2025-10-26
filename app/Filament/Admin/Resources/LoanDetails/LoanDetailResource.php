<?php

namespace App\Filament\Admin\Resources\LoanDetails;

use App\Filament\Admin\Resources\LoanDetails\Pages\CreateLoanDetail;
use App\Filament\Admin\Resources\LoanDetails\Pages\EditLoanDetail;
use App\Filament\Admin\Resources\LoanDetails\Pages\ListLoanDetails;
use App\Filament\Admin\Resources\LoanDetails\Schemas\LoanDetailForm;
use App\Filament\Admin\Resources\LoanDetails\Tables\LoanDetailsTable;
use App\Models\LoanDetail;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LoanDetailResource extends Resource
{
    protected static ?string $model = LoanDetail::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'LoanDetail';

    public static function form(Schema $schema): Schema
    {
        return LoanDetailForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LoanDetailsTable::configure($table);
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
            'index' => ListLoanDetails::route('/'),
            'create' => CreateLoanDetail::route('/create'),
            'edit' => EditLoanDetail::route('/{record}/edit'),
        ];
    }
}
