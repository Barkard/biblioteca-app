<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanReturn extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'return_date',
        'loan_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function loanDetails()
    {
        return $this->hasMany(LoanDetail::class);
    }
}
