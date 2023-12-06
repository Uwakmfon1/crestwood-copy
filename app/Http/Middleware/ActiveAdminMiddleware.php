<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActiveAdminMiddleware
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
            Auth::guard('admin')->logout();
            return redirect('/admin/login')->with('error', 'Your account has been deactivated, contact admin on '.env('SUPPORT_EMAIL'));
        }
        return $next($request);
    }
}
