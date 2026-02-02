<?php

namespace App\Filament\Admin\Resources\VisitLogs;

use App\Filament\Admin\Resources\VisitLogs\Pages\CreateVisitLog;
use App\Filament\Admin\Resources\VisitLogs\Pages\EditVisitLog;
use App\Filament\Admin\Resources\VisitLogs\Pages\ListVisitLogs;
use App\Filament\Admin\Resources\VisitLogs\Schemas\VisitLogForm;
use App\Filament\Admin\Resources\VisitLogs\Tables\VisitLogsTable;
use App\Models\VisitLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VisitLogResource extends Resource
{
    protected static ?string $model = VisitLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Registro de Visitas';

    protected static ?string $modelLabel = 'Visita';

    protected static ?string $pluralModelLabel = 'Registro de Visitas';

    protected static ?string $recordTitleAttribute = 'id_user';

    public static function form(Schema $schema): Schema
    {
        return VisitLogForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VisitLogsTable::configure($table);
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
            'index' => ListVisitLogs::route('/'),
            'create' => CreateVisitLog::route('/create'),
            'edit' => EditVisitLog::route('/{record}/edit'),
        ];
    }
}
