<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginReaderController extends Controller
{
    /**
     * Handle AJAX login for reader users.
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required','email'],
            'password' => ['required','string'],
        ]);

        // Attempt to login
        $credentials = ['email' => $data['email'], 'password' => $data['password']];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // Optional: check that the user has the Reader role
            $roleName = $user->role->name ?? null;
            Log::info("LoginReader: user {$user->id} logged in via AJAX, role={$roleName}");

            if ($roleName && strcasecmp($roleName, 'Reader') !== 0) {
                // Logout and deny access if not Reader
                Auth::logout();
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no autorizado para este acceso.'
                ], 403);
            }

            // Regenerate session to prevent fixation
            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'redirect' => route('dashboard')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Credenciales inválidas.'
        ], 422);
    }
}
