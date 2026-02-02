<?php

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Resources\Books\BookResource;
use App\Filament\Admin\Resources\LoanReturns\LoanReturnResource;
use App\Filament\Admin\Resources\Users\UserResource;
use Filament\Widgets\Widget;

class QuickActions extends Widget
{
    protected string $view = 'filament.admin.widgets.quick-actions';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public function getBookCreateUrl(): string
    {
        return BookResource::getUrl('create');
    }

    public function getUserCreateUrl(): string
    {
        return UserResource::getUrl('create');
    }

    public function getLoanCreateUrl(): string
    {
        return LoanReturnResource::getUrl('create');
    }
}
