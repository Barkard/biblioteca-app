<?php

namespace App\Filament\Admin\Resources\LoanReturns\Pages;

use App\Filament\Admin\Resources\LoanReturns\LoanReturnResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLoanReturn extends CreateRecord
{
    protected static string $resource = LoanReturnResource::class;
}
