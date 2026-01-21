<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use App\Filament\Admin\Pages\Dashboard;
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


class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->brandName(config('app.name'))
            ->id('admin')
            ->path('admin')
            ->login(\App\Filament\Auth\Pages\Login::class)
            ->profile(\App\Filament\Auth\Pages\EditProfile::class) // ← OPCIONAL: perfil de usuario
            ->colors([
                'primary' => '#800020',
            ])
            ->renderHook(
                \Filament\View\PanelsRenderHook::HEAD_END,
                fn (): string => <<<'HTML'
                <style>
                    /* Light Mode */
                    html:not(.dark) body.fi-body {
                        background-color: #fff7d6ff !important;
                    }

                    /* Dark Mode */
                    html.dark body.fi-body {
                        background: linear-gradient(to bottom, #2c2225ff, #0a0a0a) !important; /* Gradient Dark Vinotinto */
                        background-attachment: fixed !important;
                    }


                    .fi-btn-primary:hover {
                        background-color: #3a232aff !important;
                    }

                    /* Sidebar (Menú lateral) rojo al pasar el mouse */
                    .fi-sidebar-item:hover,
                    .fi-sidebar-item:hover > a,
                    .fi-sidebar-item:hover > button,
                    .fi-sidebar-item-button:hover {
                         background-color: #9c601c4b !important;
                    }
                    .fi-sidebar-item > a:hover,
                    .fi-sidebar-item > button:hover,
                    .fi-sidebar-item-button:hover {
                        background-color: #9c1c2d4b !important;
                    }
                    .fi-sidebar-item:hover span,
                    .fi-sidebar-item:hover svg {
                        color: #ffffff !important; /* Texto blanco en hover */
                    }

                    /* Estilos de Tablas (Contenido y Filas) */
                    html:not(.dark) .fi-ta-content,
                    html:not(.dark) .fi-ta-row {
                        background-color: #e2c9a7ff !important; /* Vinotinto Claro */
                    }
                    html.dark .fi-ta-content,
                    html.dark .fi-ta-row {
                        background-color: #2c2225ff !important; /* Vinotinto Oscuro */
                    }

                    /* Cabecera de Tabla (Coincidir con Topbar) */
                    html:not(.dark) .fi-ta-header-cell {
                        background-color: #997d5f !important; /* Marrón/Bronce */
                        color: #ffffff !important;
                    }
                    html:not(.dark) .fi-ta-header-cell button {
                         color: #ffffff !important;
                    }
                    html:not(.dark) .fi-ta-header-cell svg {
                         color: #ffffff !important;
                    }

                    html.dark .fi-ta-header-cell {
                        background-color: #181415ff !important; /* Dark Mode Topbar Color */
                        color: #ffffff !important;
                    }
                    html.dark .fi-ta-header-cell button {
                         color: #ffffff !important;
                    }

                    /* Buscador e Icono */
                    .fi-ta-search-field input {
                        border-color: #997d5f !important;
                    }
                    .fi-ta-search-field svg {
                        color: #997d5f !important;
                    }
                    html.dark .fi-ta-search-field svg {
                        color: #b69c81 !important; /* Lighter bronze for dark mode */
                    }

                    /* Hover Tablas */
                    html:not(.dark) .fi-ta-row:hover {
                         background-color: #ceb499ff !important;
                    }
                    html:not(.dark) .fi-ta-row:hover td {
                         background-color: #ceb499ff !important;
                    }
                    html.dark .fi-ta-row:hover {
                        background-color: #33292bff !important;
                    }
                    html.dark .fi-ta-row:hover td {
                        background-color: #3a2d30 !important;
                    }

                    /* Header / Topbar */
                    html:not(.dark) .fi-topbar {
                        background-color: #997d5fff !important; /* Marrón/Bronce */
                    }
                    html.dark .fi-topbar {
                        background-color: #181415ff !important; /* Vinotinto Oscuro */
                    }
                    .fi-topbar :is(span, svg, button) {
                        color: #ffffff !important; /* Texto blanco */
                    }
                    html:not(.dark) .fi-ta-header-toolbar {
                        background-color: #997d5fff !important; /* Marrón/Bronce */
                        border-top-right-radius: 10px !important;
                        border-top-left-radius: 10px !important;
                    }
                    html.dark .fi-ta-header-toolbar {
                        background-color: #181415ff !important; /* Pasando al oscuro */
                        border-top-right-radius: 10px !important;
                        border-top-left-radius: 10px !important;
                    }

                    html:not(.dark) .fi-ta-cell.fi-ta-selection-cell {
                        background-color: #997d5fff !important;
                    }
                    html.dark .fi-ta-cell.fi-ta-selection-cell {
                        background-color: #181415ff !important;
                    }
                    html:not(.dark) .fi-ta-header-cell.fi-ta-selection-cell {
                        background-color: #997d5fff !important;
                    }
                    html.dark .fi-ta-header-cell.fi-ta-selection-cell {
                        background-color: #181415ff !important;
                    }
                    html:not(.dark) .fi-ta-actions-header-cell.fi-ta-empty-header-cell {
                        background-color: #997d5fff !important;
                    }
                    html.dark .fi-ta-actions-header-cell.fi-ta-empty-header-cell {
                        background-color: #181415ff !important;
                    }
                    html:not(.dark) .fi-pagination {
                        background-color: #997d5fff !important;
                        border-bottom-right-radius: 10px !important;
                        border-bottom-left-radius: 10px !important;
                    }
                    html.dark .fi-pagination {
                        background-color: #181415ff !important;
                        border-bottom-right-radius: 10px !important;
                        border-bottom-left-radius: 10px !important;
                    }
                    html:not(.dark) .fi-ta-main {
                    border-color: #997d5fff !important;
                    }
                    html.dark .fi-ta-main {
                        border-color: #181415ff !important;
                    }

                    /* Buscador: Fondo blanco y texto negro */
                    html:not(.dark) .fi-ta-search-field input {
                        background-color: #80664aff !important;
                        color: #ffffffff !important;
                    }
                    html.dark .fi-ta-search-field input {
                        background-color: #0e0c0cff !important;
                        color: #ffffffff !important;
                    }

                    html:not(.dark) .fi-input-wrp-prefix.fi-input-wrp-prefix-has-content.fi-inline {
                        background-color: #80664aff !important;
                        color: #ffffffff !important;
                    }
                    html.dark .fi-input-wrp-prefix.fi-input-wrp-prefix-has-content.fi-inline {
                        background-color: #0e0c0cff !important;
                        color: #ffffffff !important;
                    }

                    /* Color de los Checkboxes */
                    html:not(.dark) .fi-checkbox-input {
                        background-color: #80664aff !important;
                    }
                    html.dark .fi-checkbox-input {
                        background-color: #0e0c0cff !important;
                    }

                    /* Color de texto de paginación */
                    .fi-pagination-overview span {
                        color: #ffffff !important;
                    }
                    html:not(.dark) .fi-input.fi-input-has-inline-prefix {
                        background-color: #80664aff !important;
                        color: #ffffffff !important;
                    }
                    html.dark .fi-input.fi-input-has-inline-prefix {
                        background-color: #0e0c0cff !important;
                        color: #ffffffff !important;
                    }

                    html:not(.dark) .fi-input-wrp-prefix.fi-input-wrp-prefix-has-content.fi-input-wrp-prefix-has-label {
                        background-color: #80664aff !important;
                        color: #ffffffff !important;
                        border-radius-left: 15px !important;
                    }
                    html.dark .fi-input-wrp-prefix.fi-input-wrp-prefix-has-content.fi-input-wrp-prefix-has-label {
                        background-color: #0e0c0cff !important;
                        color: #ffffffff !important;
                        border-radius-left: 15px !important;
                        }
                    html:not(.dark) .fi-select-input {
                        background-color: #80664aff !important;
                        color: #ffffffff !important;
                        border-radius-right: 15px !important;
                    }
                    html.dark .fi-select-input {
                        background-color: #0e0c0cff !important;
                        color: #ffffffff !important;
                        border-radius-right: 15px !important;
                    }

                    /* Login Background Image */
                    .fi-simple-layout {
                        background: url('/images/login-bg.png') no-repeat center center fixed !important;
                        background-size: cover !important;
                    }

                    /* Login Form Container Styling */
                    .fi-simple-main-ctn {
                        background-color: rgba(24, 20, 21, 0.8) !important; /* Semi-transparent dark background */
                        backdrop-filter: blur(10px);
                        border-radius: 20px;
                        padding: 2rem;
                    }

                    /* Ensure text in the login container is white/legible */
                    .fi-simple-main-ctn :is(h1, p, label, span, a, svg) {
                        color: #ffffff !important;
                    }


                </style>
HTML
            )
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\Filament\Admin\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\Filament\Admin\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\Filament\Admin\Widgets')
            ->widgets([
                // AccountWidget::class,
                // FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                EnsureUserHasRole::class . ':admin', // ← Agregar middleware con parámetro
                Authenticate::class,
             //  EnsureUserHasRole::class,
            ]);
    }
}
