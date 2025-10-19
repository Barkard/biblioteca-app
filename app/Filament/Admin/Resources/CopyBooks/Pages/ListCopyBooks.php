<?php

namespace App\Filament\Admin\Resources\CopyBooks\Pages;

use App\Filament\Admin\Resources\CopyBooks\CopyBookResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCopyBooks extends ListRecords
{
    protected static string $resource = CopyBookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
