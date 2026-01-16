<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class WelcomeOverview extends Widget
{
    protected string $view = 'filament.admin.widgets.welcome-overview';

    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    public function getUserName(): string
    {
        $user = Auth::user();
        return $user ? "{$user->name} {$user->last_name}" : 'Usuario';
    }
}
