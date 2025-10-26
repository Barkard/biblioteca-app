<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationDetail extends Model
{
    protected $fillable = [
        'status',
        'book_id',
        'reservation_id',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    } 
}
