<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AffiliateDetail;

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
        if (Auth::check() && Auth::user()->role === 'affiliate') {
            $user = Auth::user();
            
            // Ensure AffiliateDetail record exists
            if (!$user->affiliateDetail) {
                AffiliateDetail::create([
                    'user_id' => $user->id,
                    'status' => 'pending',
                    'vehicles_submitted' => false
                ]);
                $user->load('affiliateDetail');
            }

            $detail = $user->affiliateDetail;
            $status = $detail->status;

            if ($status === 'pending') {
                if (!$request->is('pending-review') && !$request->is('logout') && !$request->is('pending-review/*')) {
                    return redirect('/pending-review');
                }
            }
        }

        // Redirect away from pending page if already approved or rejected (unless logging out)
        if (Auth::check() && $request->is('pending-review')) {
            $user = Auth::user();
            $status = optional($user->affiliateDetail)->status ?? $user->status;
            
            if ($status === 'approved') {
                 return redirect('/dashboard');
            }
        }

        return $next($request);
    }
}
