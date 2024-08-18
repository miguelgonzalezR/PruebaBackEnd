<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\models\User;

class PrimerUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si hay algún usuario en la base de datos
        if (User::count() > 0) {
            return response()->json(['message' => 'Debe iniciar sesión para registrar un usuario'], 401);
        }

        return $next($request);
    }
}
