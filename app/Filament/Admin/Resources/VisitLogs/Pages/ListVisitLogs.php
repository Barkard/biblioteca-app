<?php

namespace App\Filament\Admin\Resources\VisitLogs\Pages;

use App\Filament\Admin\Resources\VisitLogs\VisitLogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVisitLogs extends ListRecords
{
    protected static string $resource = VisitLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
