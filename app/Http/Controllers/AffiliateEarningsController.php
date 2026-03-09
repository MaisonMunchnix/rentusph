<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Property;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AffiliateEarningsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Calculate Stats
        $totalEarnings = Booking::whereHasMorph('bookable', [Car::class, Property::class], function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('status', 'completed')
            ->sum('affiliate_earnings');

        $pendingEarnings = Booking::whereHasMorph('bookable', [Car::class, Property::class], function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('status', 'confirmed')
            ->sum('affiliate_earnings');

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $monthlyEarnings = Booking::whereHasMorph('bookable', [Car::class, Property::class], function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('status', 'completed')
            ->whereBetween('updated_at', [$startOfMonth, $endOfMonth])
            ->sum('affiliate_earnings');

        $totalCompletedBookings = Booking::whereHasMorph('bookable', [Car::class, Property::class], function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('status', 'completed')
            ->count();

        // Fetch paginated history
        $earningsHistory = Booking::with(['bookable'])
            ->whereHasMorph('bookable', [Car::class, Property::class], function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->whereIn('status', ['confirmed', 'completed'])
            ->orderByDesc('updated_at')
            ->paginate(10);

        return view('affiliate.earnings', compact(
            'totalEarnings',
            'pendingEarnings',
            'monthlyEarnings',
            'totalCompletedBookings',
            'earningsHistory'
        ));
    }
}
