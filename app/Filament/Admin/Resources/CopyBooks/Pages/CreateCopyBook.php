<?php

namespace App\Filament\Admin\Resources\CopyBooks\Pages;

use App\Filament\Admin\Resources\CopyBooks\CopyBookResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCopyBook extends CreateRecord
{
    protected static string $resource = CopyBookResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
