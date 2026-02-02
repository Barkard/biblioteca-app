<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class BookObserver
{
    public function created(Book $book): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'description' => 'se añadió el libro "' . $book->title . '"',
        ]);
    }

    public function updated(Book $book): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'description' => 'se actualizó el libro "' . $book->title . '"',
        ]);
    }

    public function deleted(Book $book): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'description' => 'se eliminó el libro "' . $book->title . '"',
        ]);
    }
}
