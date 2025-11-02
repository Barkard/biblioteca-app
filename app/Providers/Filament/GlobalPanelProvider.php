<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Http\Middleware\EnsureUserHasRole;

class GlobalPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('global')
            ->path('global')
            ->login(\App\Filament\Auth\Pages\Login::class)
            ->registration(action: \App\Filament\Auth\Pages\Register::class) // opcional
            ->passwordReset()
            ->emailVerification()
            ->profile(\App\Filament\Auth\Pages\EditProfile::class)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/global/Resources'), for: 'App\Filament\global\Resources')
            ->discoverPages(in: app_path('Filament/global/Pages'), for: 'App\Filament\global\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/global/Widgets'), for: 'App\Filament\global\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                DispatchServingFilamentEvent::class,
            ])
                // Solo requiere autenticación; NO verifica role
            ->authMiddleware([
                EnsureUserHasRole::class . ':global', // ← Agregar middleware con parámetro
                Authenticate::class,
            ]);
    }
}
