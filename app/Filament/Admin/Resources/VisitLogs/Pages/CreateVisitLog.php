<?php

namespace App\Filament\Admin\Resources\VisitLogs\Pages;

use App\Filament\Admin\Resources\VisitLogs\VisitLogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVisitLog extends CreateRecord
{
    protected static string $resource = VisitLogResource::class;
}
