<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PreventUserFromAdminAccess
{
    /**
     * Primary function of this middleware is to prevent athenticated user from access admin pages
     */

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(Auth::check()){
            return redirect()->route('home');
        }

        return $next($request);
    }
}
