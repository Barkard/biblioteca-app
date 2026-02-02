<?php

namespace App\Filament\Admin\Resources\VisitLogs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Exports\VisitLogsReportExport;
use Maatwebsite\Excel\Facades\Excel;

class VisitLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_user')
                    ->label('Cédula')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('gender')
                    ->label('Género')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'female' => 'Femenino',
                        'male' => 'Masculino',
                        default => $state,
                    })
                    ->searchable(),
                TextColumn::make('age')
                    ->label('Edad')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Fecha de Registro')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Última Actualización')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->headerActions([
                Action::make('generate_report')
                    ->label('Generar Reporte')
                    ->form([
                        DatePicker::make('date_from')
                            ->label('Fecha desde')
                            ->required(),
                        DatePicker::make('date_to')
                            ->label('Fecha hasta')
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        return Excel::download(new VisitLogsReportExport($data['date_from'], $data['date_to']), 'visit_logs_report.xlsx');
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
