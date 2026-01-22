<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CopyBook extends Model
{
    protected $fillable = [
        'cota',
        'book_id',
        'status',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function loanDetails()
    {
        return $this->hasMany(LoanDetail::class);
    }

    public function nextAvailableDate()
    {
        if ($this->status) {
            return null;
        }

        return $this->loanDetails()
            ->latest('return_date')
            ->first()
            ?->return_date;
    }
}
