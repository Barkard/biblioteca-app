<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanReturn extends Model
{
    protected $fillable = [
        'status',
        'return_date',
        'loan_detail',
    ];
}
