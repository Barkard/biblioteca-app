<?php

namespace App\Filament\Admin\Widgets;

use App\Models\ActivityLog;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ActivityLogWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    
    // Ensure it's at the bottom. QuickActions probably has specific sort or default.
    // I'll set a high number.
    protected static ?int $sort = 100; 

    protected static ?string $heading = 'Historial';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ActivityLog::query()->latest()
            )
            ->extraAttributes([
                'class' => 'custom-activity-log !shadow-lg',
            ])
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->since() // Muestra "hace 1 día", "ayer" (dependiendo de locale)
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción')
                    ->wrap(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Responsable')
                    ->formatStateUsing(fn ($state, $record) => $record->user ? "{$record->user->name} {$record->user->last_name}" : 'Sistema')
                    ->sortable(),
            ])
            ->paginated(false) // Optional: restrict if too many logs, or set pagination
            ->defaultPaginationPageOption(5);
    }
}
