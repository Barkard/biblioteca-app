<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginReaderController;

Route::get('/', function () {
    return view('welcome');
});

// AJAX login endpoint for reader users
Route::post('/reader/login', [LoginReaderController::class, 'login'])->name('reader.login');

// Dashboard placeholder route (ensure exists in your app)
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
