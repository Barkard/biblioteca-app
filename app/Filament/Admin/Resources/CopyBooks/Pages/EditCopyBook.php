<?php

namespace App\Filament\Admin\Resources\CopyBooks\Pages;

use App\Filament\Admin\Resources\CopyBooks\CopyBookResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCopyBook extends EditRecord
{
    protected static string $resource = CopyBookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
