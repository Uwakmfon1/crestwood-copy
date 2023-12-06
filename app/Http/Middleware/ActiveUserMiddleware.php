<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActiveUserMiddleware
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
        if (auth()->user()['active'] == 0){
            Auth::guard()->logout();
            return redirect('/login')->with('error', 'Your account has been deactivated, contact admin on '.env('SUPPORT_EMAIL'));
        }
        return $next($request);
    }
}
