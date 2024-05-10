<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MechanicMiddleware
{
    /**
     * Handle an incoming request.
     * Redirects or next depending on if the user is an admin
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {

        if (!Auth::check() && (Auth::user()->role_id == 1 || Auth::user()->role_id == 2)) { // mechanic en admin role_id hier straks aanpassen
            return $next($request);
        } else {
            return redirect()->back()->with('error', 'Je hebt geen toegang tot deze pagina.');
        }
    }
}
