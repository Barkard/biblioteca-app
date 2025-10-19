<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanDetail extends Model
{
    protected $fillable = [
        'status',
        'return_date',
    ];
}
