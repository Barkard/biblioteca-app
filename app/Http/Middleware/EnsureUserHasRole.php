<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string $panel): Response
    {
        $user = auth()->user();
        // Solo permitimos el panel admin y sólo para usuarios con rol 'Admin'.
        if (! $user) {
            // Redirigir al login del panel admin
            return redirect(url('/admin/login'));
        }

        // Asegura que la relación role esté cargada
        $user->loadMissing('role');
        $roleName = $user->role->name ?? null;

        Log::info("EnsureUserHasRole: usuario {$user->id} con rol '{$roleName}' accediendo al panel '{$panel}'");

        // Si el usuario no es Admin, no tiene acceso al panel admin
        if (strcasecmp($roleName ?? '', 'Admin') !== 0) {
            abort(403, 'No tienes acceso a este panel.');
        }

        // Si se accedió con un panel distinto a 'admin', redirigimos al admin
        if (strtolower($panel) !== 'admin') {
            return redirect(url('/admin'));
        }

        return $next($request);
    }
}
