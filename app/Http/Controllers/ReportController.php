<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        // 1. Stats
        $totalBookingsThisMonth = Booking::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $totalRevenueThisMonth = Booking::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->whereIn('status', ['confirmed', 'completed'])
            ->sum('total_price');
        $activeDeliveries = Booking::where('status', 'confirmed')
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->count();

        // 2. Charts - Bookings & Revenue Summary (Monthly for the year)
        $monthlyData = Booking::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(CASE WHEN status IN ("confirmed", "completed") THEN total_price ELSE 0 END) as revenue')
        )
            ->whereYear('created_at', $now->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $chartBookings = [];
        $chartRevenue = [];

        for ($i = 1; $i <= 12; $i++) {
            $monthData = $monthlyData->get($i);
            $chartBookings[] = $monthData ? $monthData->count : 0;
            $chartRevenue[] = $monthData ? (float) $monthData->revenue : 0;
        }

        // 3. Most Rented Cars (Donut Chart)
        $popularCarsData = Booking::where('bookable_type', 'App\Models\Car')
            ->select('bookable_id', DB::raw('count(*) as total'))
            ->groupBy('bookable_id')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $popularCarsLabels = [];
        $popularCarsSeries = [];
        foreach ($popularCarsData as $data) {
            $car = Car::find($data->bookable_id);
            if ($car) {
                $popularCarsLabels[] = $car->brand . ' ' . $car->model;
                $popularCarsSeries[] = (int) $data->total;
            }
        }

        // If no data, provide defaults to avoid empty charts
        if (empty($popularCarsSeries)) {
            $popularCarsLabels = ['No Data'];
            $popularCarsSeries = [0];
        }

        // 4. Top Performing Cars (Table)
        $topPerformingCars = Car::with(['user'])
            ->withCount(['bookings' => function($query) {
                $query->whereIn('status', ['confirmed', 'completed']);
            }])
            ->withSum(['bookings' => function($query) {
                $query->whereIn('status', ['confirmed', 'completed']);
            }], 'total_price')
            ->orderByDesc('bookings_count')
            ->take(10)
            ->get();

        return view('admin.reports', compact(
            'totalBookingsThisMonth',
            'totalRevenueThisMonth',
            'activeDeliveries',
            'chartLabels',
            'chartBookings',
            'chartRevenue',
            'popularCarsLabels',
            'popularCarsSeries',
            'topPerformingCars'
        ));
    }
}
