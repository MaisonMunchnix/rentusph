<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Property;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return $this->adminDashboard();
        } elseif ($user->role === 'affiliate') {
            return $this->affiliateDashboard();
        } elseif ($user->role === 'customer') {
            return redirect()->route('customer.explore');
        }

        return redirect()->route('login');
    }

    private function adminDashboard()
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        // Financial Stats
        $totalCommission = Booking::whereIn('status', ['confirmed', 'completed'])->sum('platform_commission');
        $monthlyCommission = Booking::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->whereIn('status', ['confirmed', 'completed'])
            ->sum('platform_commission');
        
        $activeBookings = Booking::where('status', 'confirmed')->count();
        $totalAffiliates = User::where('role', 'affiliate')->count();

        // Recent Commission History
        $recentBookings = Booking::with(['bookable'])
            ->whereIn('status', ['confirmed', 'completed'])
            ->orderByDesc('updated_at')
            ->take(5)
            ->get();

        return view('admin.index', compact(
            'totalCommission',
            'monthlyCommission',
            'activeBookings',
            'totalAffiliates',
            'recentBookings'
        ));
    }

    private function affiliateDashboard()
    {
        $user = Auth::user();

        // Only count earnings from completed bookings
        $totalEarnings = Booking::whereHasMorph('bookable', [Car::class, Property::class], function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('status', 'completed')
            ->sum('affiliate_earnings');

        // Pending earnings are from confirmed bookings
        $pendingEarnings = Booking::whereHasMorph('bookable', [Car::class, Property::class], function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('status', 'confirmed')
            ->sum('affiliate_earnings');

        $activeListings = Car::where('user_id', $user->id)->count() + Property::where('user_id', $user->id)->count();
        
        $recentEarnings = Booking::whereHasMorph('bookable', [Car::class, Property::class], function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->whereIn('status', ['confirmed', 'completed'])
            ->orderByDesc('updated_at')
            ->take(5)
            ->get();

        return view('affiliate.index', compact(
            'totalEarnings',
            'pendingEarnings',
            'activeListings',
            'recentEarnings'
        ));
    }
}
