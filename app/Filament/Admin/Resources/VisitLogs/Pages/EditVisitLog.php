<?php

namespace App\Filament\Admin\Resources\VisitLogs\Pages;

use App\Filament\Admin\Resources\VisitLogs\VisitLogResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVisitLog extends EditRecord
{
    protected static string $resource = VisitLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
