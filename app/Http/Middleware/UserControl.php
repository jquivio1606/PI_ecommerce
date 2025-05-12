<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Verifica que el usuario esté autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Verifica si el rol del usuario coincide con el rol proporcionado
        if (Auth::user()->role == $role) {
            return $next($request);
        }

        abort(403, 'Acceso no autorizado');
    }
}
