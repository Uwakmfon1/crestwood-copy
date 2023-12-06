<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ProfileCompleteMiddleware
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
        $user = auth()->user();
        if (!($user['name'] && $user['email'] && $user['phone'] &&
            $user['state'] && $user['country'] && $user['city'] &&
            $user['address'] && $user['bank_name'] && $user['account_name'] &&
            $user['account_number'] && $user['nk_name'] && $user['nk_phone'] &&
            $user['nk_address']))
            return redirect()->route('profile')->with('info', 'Kindly complete your profile to proceed');
        return $next($request);
    }
}
