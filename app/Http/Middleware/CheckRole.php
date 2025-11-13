<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check() || !in_array(Auth::user()->FK_TipoUsuario, $roles) || Auth::user()->Activo != 1) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }}
