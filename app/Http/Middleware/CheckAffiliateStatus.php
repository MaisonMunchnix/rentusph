<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAffiliateStatus
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
        if (Auth::check() && Auth::user()->role === 'affiliate' && Auth::user()->status === 'pending') {
            if (!$request->is('pending-review')) {
                return redirect('/pending-review');
            }
        }

        // If approved affiliate or customer trying to access pending-review, send them away (unless logging out)
        if (Auth::check() && Auth::user()->status === 'approved' && $request->is('pending-review')) {
             return redirect('/dashboard');
        }

        return $next($request);
    }
}
