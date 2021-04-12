<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificarSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Auth::user()->hasRole('Super Admin') && Auth::user()->plaza->id !== $request->route('plaza')->id) {
            throw new AuthorizationException('User does not have the right permissions.');
        }
        return $next($request);
    }
}
