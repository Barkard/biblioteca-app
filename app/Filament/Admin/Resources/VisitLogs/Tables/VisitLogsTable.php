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
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('gender')
                    ->searchable(),
                TextColumn::make('age')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
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
