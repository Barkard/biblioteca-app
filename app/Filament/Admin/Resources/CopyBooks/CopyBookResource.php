<?php

namespace App\Filament\Admin\Resources\CopyBooks;

use App\Filament\Admin\Resources\CopyBooks\Pages\CreateCopyBook;
use App\Filament\Admin\Resources\CopyBooks\Pages\EditCopyBook;
use App\Filament\Admin\Resources\CopyBooks\Pages\ListCopyBooks;
use App\Filament\Admin\Resources\CopyBooks\Schemas\CopyBookForm;
use App\Filament\Admin\Resources\CopyBooks\Tables\CopyBooksTable;
use App\Models\CopyBook;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CopyBookResource extends Resource
{
    protected static ?string $model = CopyBook::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'CopiaLibros';

    public static function form(Schema $schema): Schema
    {
        return CopyBookForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CopyBooksTable::configure($table);
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
            'index' => ListCopyBooks::route('/'),
            'create' => CreateCopyBook::route('/create'),
            'edit' => EditCopyBook::route('/{record}/edit'),
        ];
    }
}
