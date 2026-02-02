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
            ->brandName('Biblioteca')
            ->brandLogo(asset('images/world-book-day.svg'))
            ->darkModeBrandLogo(asset('images/world-book-day-dark.svg'))
            ->brandLogoHeight('3rem')
            ->id('admin')
            ->path('admin')
            ->login(\App\Filament\Auth\Pages\Login::class)
            ->profile(\App\Filament\Auth\Pages\EditProfile::class) // ← OPCIONAL: perfil de usuario
            ->colors([
                'primary' => '#0ce23aff',
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
                    html:not(.dark) .fi-ta-header {
                        background-color: #997d5f !important; /* Marrón/Bronce */
                        color: #ffffff !important;
                        border-top-left-radius: 10px !important;
                        border-top-right-radius: 10px !important;
                    }
                    html.dark .fi-ta-header {
                        background-color: #181415 !important; /* Marrón/Bronce */
                        color: #ffffff !important;
                        border-top-left-radius: 10px !important;
                        border-top-right-radius: 10px !important;
                    }
                    .fi-ta-ctn fi-ta-ctn-with-header {
                        border-top-left-radius: 10px !important;
                        border-top-right-radius: 10px !important;
                    }
                    
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
                    border-radius: 10px !important;
                    }
                    html.dark .fi-ta-main {
                        border-color: #181415ff !important;
                        border-radius: 10px !important;
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
                        background-color: #80664a !important;
                        color: #ffffffff !important;
                        border-radius-right: 15px !important;
                    }
                    html.dark .fi-select-input {
                        background-color: #0e0c0cff !important;
                        color: #ffffffff !important;
                        border-radius-right: 15px !important;
                    }

                    /* Global Form Fields Styling */
                    html:not(.dark) .fi-input-wrp {
                        background-color: #80664a !important;
                        color: #ffffff !important;
                    }
                    html.dark .fi-input-wrp {
                        background-color: #0e0c0cff !important;
                        color: #ffffff !important;
                    }

                    /* Ensure actual input/select elements have white text */
                    .fi-input, .fi-select-input {
                        color: #ffffff !important;
                    }

                    /* Repeater Add Buttons */
                    html:not(.dark) :is(.fi-fo-repeater-add, .fi-fo-repeater-add-between-items) button {
                        background-color: #80664a !important;
                    }
                    html.dark :is(.fi-fo-repeater-add, .fi-fo-repeater-add-between-items) button {
                        background-color: #0e0c0cff !important;
                    }

                    /* File Upload (Portada) */
                    html:not(.dark) .fi-fo-file-upload .filepond--panel-root {
                        background-color: #80664a !important;
                    }
                    html.dark .fi-fo-file-upload .filepond--panel-root {
                        background-color: #0e0c0cff !important;
                    }
                    html.dark .fi-fo-file-upload {
                        background-color: #0e0c0cff !important;
                        border-radius: 10px !important;
                    }
                    html:not(.dark) .fi-fo-file-upload {
                        background-color: #80664a !important;
                        border-radius: 10px !important;
                    }

                    /* Modals Styling */
                    html:not(.dark) .fi-modal-window {
                        background-color: #fff7d6 !important;
                        border-radius: 20px !important;
                        overflow-y: auto !important;
                        overflow-x: hidden !important;
                    }
                    html.dark .fi-modal-window {
                        background: linear-gradient(to bottom, #2c2225ff, #0a0a0a) !important; /* Gradient Dark Vinotinto */
                        background-attachment: fixed !important;
                        border-radius: 20px !important;
                        overflow-y: auto !important;
                        overflow-x: hidden !important;
                    }

                    /* Ensure all modal sections follow the background */
                    .fi-modal-header, .fi-modal-content, .fi-modal-footer {
                        background-color: inherit !important;
                    }

                    /* Modal Text and Heading visibility */
                    .fi-modal-heading, .fi-modal-description {
                        color: #ffffff !important;
                    }

                    /* Login Background Image */
                    .fi-simple-layout {
                        background: url('/images/login-bg.png') no-repeat center center fixed !important;
                        background-size: cover !important;
                    }

                    /* Login Form Container Styling */
                    .fi-simple-main-ctn {
                        background-color: rgba(24, 20, 21, 0.8) !important; /* Semi-transparent dark background */
                        backdrop-filter: blur(1px);
                        padding: 2rem;
                    }

                    /* Ensure text in the login container is white/legible */
                    .fi-simple-main-ctn :is(h1, p, label, span, a, svg) {
                        color: #ffffff !important;
                    }
                    html:not(.dark) .fi-ta-header.fi-ta-header-adaptive-actions-position {
                        background-color: #80664aff !important;
                        border-top-right-radius: 10px !important;
                        border-top-left-radius: 10px !important;
                    }
                    html.dark .fi-ta-header.fi-ta-header-adaptive-actions-position {
                        background-color: #0e0c0cff !important;
                        border-top-right-radius: 10px !important;
                        border-top-left-radius: 10px !important;
                    }

                    html:not(.dark) .fi-icon-btn.fi-size-md.fi-ac-icon-btn-action.fi-force-enabled{
                        color: #58442fff;
                    }



                    html.dark .fi-sidebar-item-btn svg {
                        color: #c0b9b9ff;
                    }

                    html:not(.dark) .fi-sidebar-item-btn svg {
                        color: #58442fff;
                    }
                    html.dark .fi-icon-btn.fi-size-md.fi-ac-icon-btn-action.fi-force-enabled{
                        color: #0c0a0aff;
                    }

                    /* Sidebar Items Styling */

                    .fi-sidebar-item.fi-active .fi-sidebar-item-btn {
                        background-color: #997d5f !important; /* Visible background when active (Light) */
                    }
                    html.dark .fi-sidebar-item.fi-active .fi-sidebar-item-btn {
                        background-color: #181415ff !important; /* Visible background when active (Dark) */
                    }

                    /* Sidebar Hover */
                    .fi-sidebar-item-btn:hover {
                         background-color: #997d5f !important; /* Subtle hover effect (Light) */
                    }
                    html.dark .fi-sidebar-item-btn:hover {
                         background-color: #181415ff !important; /* Subtle hover effect (Dark) */
                    }

                    /* Neutralize broad hover rules that might affect layout */
                    .fi-sidebar-item:hover,
                    .fi-sidebar-item-button:hover {
                         background-color: transparent !important;
                    }

                    /* LOGIN DISEÑO */
                    html:not(.dark) .fi-simple-main.fi-width-lg {
                        background-color: #e2c9a7ff !important;
                        border-radius: 20px !important;
                    }
                    html.dark .fi-simple-main.fi-width-lg {
                        background-color: #2c2225ff !important;
                        border-radius: 20px !important;
                    }
                    /*color #80664a del span*/
                    .fi-fo-field-label-content {
                        color: #80664a !important;
                    }
                    /* Evitar que el color global afecte a los spans internos de validación o hints */
                    .fi-fo-field-label-content span:not([style]) {
                        color: inherit !important;
                    }
                    .fi-simple-header h1 {
                        color: #80664a !important;
                    }
                    html.dark .fi-simple-header h1 {
                        color: #c0b9b9ff !important;
                    }

                    html:not(.dark) .fi-fo-field-label-content {
                        color: #58442fff !important;
                    }
                    html.dark .fi-fo-field-label-content {
                        color: #c0b9b9ff !important;
                    }

                    /* Login Inputs and Password Toggle */
                    html:not(.dark) .fi-simple-main-ctn .fi-input-wrp {
                        background-color: #80664aff !important;
                    }
                    html.dark .fi-simple-main-ctn .fi-input-wrp {
                        background-color: #0e0c0cff !important;
                    }
                    html:not(.dark) .fi-simple-main-ctn .fi-input-wrp-actions button {
                        background-color: #80664aff !important;
                    }
                    html.dark .fi-simple-main-ctn .fi-input-wrp-actions button {
                        background-color: #0e0c0cff !important;
                    }

                    html:not(.dark) .fi-dropdown-list {
                        background-color: #997d5f !important;
                    }
                    html.dark .fi-dropdown-list {
                        background-color: #181415 !important;
                    }

                    /* Hover Theme Switcher */
                    html:not(.dark) .fi-theme-switcher-btn:hover {
                        background-color: #80664aff !important;
                    }
                    html.dark .fi-theme-switcher-btn:hover {
                        background-color: #0e0c0cff !important;
                    }

                    html:not(.dark) .fi-theme-switcher-btn.fi-active {
                        background-color: #80664aff !important;
                    }
                    html.dark .fi-theme-switcher-btn.fi-active {
                        background-color: #0e0c0cff !important;
                    }

                    /* General Form Input Styling (Dark Mode) */
                    html.dark .fi-fo-text-input .fi-input-wrp,
                    html.dark .fi-fo-select .fi-input-wrp,
                    html.dark .fi-fo-date-picker .fi-input-wrp,
                    html.dark .fi-fo-phone-input .fi-input-wrp,
                    html.dark .fi-fo-text-area .fi-input-wrp {
                        background-color: #0e0c0cff !important;
                        border-color: #3b2c2eff !important;
                    }

                    html.dark .fi-input-wrp:focus-within {
                        border-color: #0ce23aff !important;
                        box-shadow: 0 0 0 1px #0ce23aff !important;
                    }

                    html.dark input,
                    html.dark select,
                    html.dark textarea {
                        color: #ffffff !important;
                        background-color: transparent !important;
                    }

                    html.dark .fi-input-wrp input::placeholder {
                        color: #71717a !important;
                    }
                    
                </style>
HTML
            )
            ->renderHook(
                \Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE,
                fn (): string => \Illuminate\Support\Facades\Blade::render('<div class="flex justify-center mb-4" x-data="{ close: () => {} }"><x-filament-panels::theme-switcher /></div>'),
            )
            ->renderHook(
                \Filament\View\PanelsRenderHook::FOOTER,
                fn (): string => request()->routeIs('filament.admin.auth.login') ? '' : view('filament.admin.footer')->render(),
            )
            ->renderHook(
                \Filament\View\PanelsRenderHook::HEAD_END,
                fn (): string => '<style>
                    /* Custom Widget Styles */
                    .custom-welcome-widget, 
                    .custom-quick-actions-widget,
                    .custom-stat-card,
                    .custom-activity-log {
                        background-color: #997d5f !important;
                        color: white !important;
                        border-radius: 10px !important;
                        overflow: hidden !important;
                    }

                    .custom-stat-card > div, 
                    .custom-stat-card span,
                    .custom-activity-log,
                    .custom-activity-log .fi-ta-header-heading {
                        color: white !important;
                    }

                    html.dark .custom-welcome-widget, 
                    html.dark .custom-quick-actions-widget,
                    html.dark .custom-stat-card,
                    html.dark .custom-activity-log {
                        background-color: #181415 !important;
                        border: 1px solid #374151; /* Optional border for dark mode */
                        border-radius: 10px !important;
                    }
                    
                    /* Override Filament generic card backgrounds if needed */
                    .custom-stat-card {
                        --tw-bg-opacity: 1;
                    }
                </style>',
            )
            ->renderHook(
                \Filament\View\PanelsRenderHook::BODY_END,
                fn (): string => request()->routeIs('filament.admin.auth.login') ? '' : view('filament.admin.help-button')->render(),
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
