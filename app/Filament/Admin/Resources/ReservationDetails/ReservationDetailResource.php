<?php

namespace App\Filament\Admin\Resources\ReservationDetails;

use App\Filament\Admin\Resources\ReservationDetails\Pages\CreateReservationDetail;
use App\Filament\Admin\Resources\ReservationDetails\Pages\EditReservationDetail;
use App\Filament\Admin\Resources\ReservationDetails\Pages\ListReservationDetails;
use App\Filament\Admin\Resources\ReservationDetails\Schemas\ReservationDetailForm;
use App\Filament\Admin\Resources\ReservationDetails\Tables\ReservationDetailsTable;
use App\Models\ReservationDetail;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ReservationDetailResource extends Resource
{
    protected static ?string $model = ReservationDetail::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $modelLabel = 'Detalle de Reserva';
    protected static ?string $pluralModelLabel = 'Detalles de Reservas';
    protected static ?string $navigationLabel = 'Detalles de Reservas';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return ReservationDetailForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReservationDetailsTable::configure($table);
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
            'index' => ListReservationDetails::route('/'),
            'create' => CreateReservationDetail::route('/create'),
            'edit' => EditReservationDetail::route('/{record}/edit'),
        ];
    }
}
