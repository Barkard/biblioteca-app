<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;

class UserManual extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    protected string $view = 'filament.admin.pages.user-manual';

    protected static ?string $title = 'Manual de Usuario';

    protected static ?string $slug = 'manual-de-usuario';
    
    protected static bool $shouldRegisterNavigation = false;
}
