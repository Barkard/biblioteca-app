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

        if (! $user) {
            // No autenticado: llevar al login del panel solicitado
            return redirect(url("/{$panel}/login"));
        }

        // Asegura que la relación role esté cargada
        $user->loadMissing('role');
        $roleName = $user->role->name ?? null;

        Log::info("EnsureUserHasRole: usuario {$user->id} con rol '{$roleName}' accediendo al panel '{$panel}'");

        // Redirección automática según rol:
        if (strcasecmp($roleName ?? '', 'Admin') === 0 && $panel !== 'admin') {
            return redirect(url('/admin'));
        }

        if (strcasecmp($roleName ?? '', 'Reader') === 0 && $panel !== 'global' && $panel !== 'panel') {
            // redirige al panel global (ruta /panel). acepta 'global' o 'panel' según tu provider.
            return redirect(url('/global'));
        }

        // Comprobación de roles permitidos para el panel (ajusta según políticas)
        $allowedRoles = $this->getAllowedRoles($panel);
        if (! in_array($roleName, $allowedRoles, true)) {
            abort(403, 'No tienes acceso a este panel.');
        }

        return $next($request);
    }

    private function getAllowedRoles(string $panel): array
    {
        return match (strtolower($panel)) {
            'admin' => ['Admin', 'Staff'],
            'global', 'panel' => ['Reader', 'Admin'], // permite también Admin acceder al panel global si lo deseas
            default => [],
        };
    }
}
