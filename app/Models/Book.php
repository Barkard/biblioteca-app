<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author_id',
        'category_id',
        'status',
        'Edition',
        'date_published',
        'synopsis',
    ];
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function copyBooks()
    {
        return $this->hasMany(CopyBook::class);
    }

    public function reservationDetails()
    {
        return $this->hasMany(ReservationDetail::class);
    }
}
