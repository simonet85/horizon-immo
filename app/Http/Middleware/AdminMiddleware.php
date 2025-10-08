<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string|null  $role  Role requis (admin, client, etc.)
     */
    public function handle(Request $request, Closure $next, $role = null): Response
    {
        // Vérifier si l'utilisateur est connecté
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        // Si un rôle spécifique est requis
        if ($role) {
            if (! auth()->user()->hasRole($role)) {
                abort(403, 'Accès refusé. Rôle requis: '.$role);
            }
        } else {
            // Si aucun rôle spécifié, vérifier qu'il a au moins admin ou client
            if (! auth()->user()->hasAnyRole(['admin', 'client'])) {
                abort(403, 'Accès refusé. Vous devez avoir un rôle administratif.');
            }
        }

        return $next($request);
    }
}
