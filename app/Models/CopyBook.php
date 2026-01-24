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

        $latestDetail = $this->loanDetails()
            ->with('loanReturn')
            ->latest()
            ->first();

        if (!$latestDetail) {
            return null;
        }

        // Return the specific return date from detail, or the official one from the loan record
        return $latestDetail->return_date ?? $latestDetail->loanReturn?->return_date;
    }
}
