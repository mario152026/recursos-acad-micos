<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckActive
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && ! Auth::user()->activo) {
            Auth::logout();
            return redirect('/')
                ->withErrors(['Tu cuenta está desactivada. Contacta a un administrador.']);
        }

        return $next($request);
    }
}
