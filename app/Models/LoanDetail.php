<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanDetail extends Model
{
    protected $fillable = [
        'copy_book_id',
        'loan_return_id',
        'status',
        'return_date',
    ];

    public function copyBook()
    {
        return $this->belongsTo(CopyBook::class);
    }

    public function loanReturn()
    {
        return $this->belongsTo(LoanReturn::class);
    }
}
