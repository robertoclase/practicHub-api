<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     * Verifica que el usuario autenticado tenga uno de los roles permitidos
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user()) {
            return response()->json(['message' => 'No autenticado'], 401);
        }

        // Obtener el rol del usuario (puede ser User o Empresa)
        $userRole = $request->user()->role ?? 'empresa';

        if (!in_array($userRole, $roles)) {
            return response()->json([
                'message' => 'No tienes permisos para acceder a este recurso',
                'required_roles' => $roles,
                'your_role' => $userRole
            ], 403);
        }

        return $next($request);
    }
}
