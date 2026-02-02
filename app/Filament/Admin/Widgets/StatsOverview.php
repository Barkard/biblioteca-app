<?php

namespace App\Filament\Admin\Widgets;

use App\Models\CopyBook;
use App\Models\LoanReturn;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Usuarios', User::count())
                ->description('Usuarios registrados')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary')
                ->extraAttributes([
                    'class' => 'custom-stat-card',
                    'style' => '--stat-color-light: #997d5f; --stat-color-dark: #181415;',
                ]),
            Stat::make('Libros', CopyBook::count()) // Usage of CopyBook as requested
                ->description('Ejemplares disponibles')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('success')
                ->extraAttributes([
                    'class' => 'custom-stat-card',
                    'style' => '--stat-color-light: #997d5f; --stat-color-dark: #181415;',
                ]),
            Stat::make('Préstamos', LoanReturn::count())
                ->description('Total de préstamos')
                ->descriptionIcon('heroicon-m-arrow-path-rounded-square')
                ->color('warning')
                ->extraAttributes([
                    'class' => 'custom-stat-card',
                    'style' => '--stat-color-light: #997d5f; --stat-color-dark: #181415;',
                ]),
        ];
    }
}
