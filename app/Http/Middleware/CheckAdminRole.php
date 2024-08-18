<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class CheckAdminRole
{

    public function handle(Request $request, Closure $next)
    {
        // Verifica si el usuario está autenticado
        if (Auth::check()) {
            // Verifica si el rol del usuario es "administrador"
            if (Auth::user()->rol === 'Administrador') {
                return $next($request);
            }
        }

        // Si no es administrador, retorna un error 403 Forbidden
        return response()->json(['message' => 'Acceso denegado'], 403);
    }
}
