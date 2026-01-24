<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginReaderController;

Route::get('/', function () {
    //panel admin login
    return redirect('admin/login');
});

// AJAX login endpoint for reader users
Route::post('/reader/login', [LoginReaderController::class, 'login'])->name('reader.login');

Route::get('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Dashboard placeholder route (ensure exists in your app)
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/test-whatsapp', function () {
    // 1. Create User
    $user = \App\Models\User::firstOrCreate(
        ['email' => 'test_wapp@example.com'],
        [
            'name' => 'Kevin',
            'second_name' => 'Test',
            'last_name' => 'User',
            'second_last_name' => '',
            'role_id' => \App\Models\Role::first()?->id ?? 1,
            'password' => bcrypt('password'),
            'nationality' => 'V',
            'id_user' => 12345678, // Dummy ID
            'country_code' => '+58',
            'phone' => '4165026559', // The number provided
            'status' => true,
        ]
    );

    // Ensure phone is updated if user existed
    $user->update([
        'country_code' => '+58',
        'phone' => '4165026559'
    ]);

    // 2. Create Loan Return due in 2 days
    $loan = \App\Models\LoanReturn::create([
        'user_id' => $user->id,
        'return_date' => \Carbon\Carbon::now()->addDays(2)->format('Y-m-d'),
        'status' => true,
    ]);

    // 3. Manually run the job's logic (or the job itself) and capture logs?
    // We'll just run the code here to see output immediately.

    $dueDate = \Carbon\Carbon::now()->addDays(2)->format('Y-m-d');
    $loans = \App\Models\LoanReturn::query()
            ->where('status', true)
            ->whereDate('return_date', $dueDate)
            ->with('user')
            ->get();

    $results = [];
    foreach ($loans as $loanItem) {
        $u = $loanItem->user;
        if ($u && $u->phone && $u->country_code) {
             $fullPhone = $u->country_code . $u->phone;
             $msg = "WAPP_SEND: Reminder for {$u->name} {$u->last_name} ({$fullPhone}). Loan due on {$dueDate}.";
             \Illuminate\Support\Facades\Log::info($msg);
             $results[] = $msg;
        }
    }

    return response()->json([
        'status' => 'Test executed',
        'created_loan_id' => $loan->id,
        'user_phone_stored' => $user->country_code . $user->phone,
        'logs_generated' => $results
    ]);
});

