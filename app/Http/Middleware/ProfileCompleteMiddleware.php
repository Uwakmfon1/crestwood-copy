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
        if (!($user['first_name'] && $user['email'] && $user['phone'] &&
            $user['country'] && 
            $user['address'] && $user['bank_name'] &&
            $user['nk_address']))
            return redirect()->route('user.kyc')->with('info', 'Kindly complete your profile to proceed');
        return $next($request);
    }
}
