<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;
use Validation;

class Initialized
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Account is enabled validation
        if(Auth::user()->roles->count() === 0)
        {
            Auth::logout();
            return redirect()->back()->withErrors(['Su cuenta se encuentra deshabilitada']);
        }
        
        return $next($request);
    }
}