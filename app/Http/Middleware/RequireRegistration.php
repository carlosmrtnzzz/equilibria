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
            return redirect()->route('register')->with('message', 'Debes registrarte para acceder a esta sección.');
        }

        return $next($request);
    }
}
