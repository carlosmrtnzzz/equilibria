<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequireRegistration
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            if ($request->ajax()) {
                return response()->json(['error' => 'No autorizado'], 401);
            }
            return redirect()->route('login')->with('info', 'Debes iniciar sesión para acceder a esta sección.');
        }

        return $next($request);
    }
}
