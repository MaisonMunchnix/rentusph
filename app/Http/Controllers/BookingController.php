<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Property;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Auth::user()->bookings()->with('bookable')->latest()->get();
        return view('customer.bookings', compact('bookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bookable_id' => 'required',
            'bookable_type' => 'required|in:App\Models\Car,App\Models\Property',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:255',
        ]);

        $bookableClass = $request->bookable_type;
        $bookable = $bookableClass::findOrFail($request->bookable_id);

        $startDate = Carbon::parse($request->start_date);
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : $startDate;
        
        $days = $startDate->diffInDays($endDate) ?: 1;
        
        $totalPrice = 0;
        if ($request->bookable_type === 'App\Models\Car') {
            $totalPrice = $bookable->daily_rate * $days;
        } else {
            $dailyRate = $bookable->monthly_rate / 30;
            $totalPrice = $dailyRate * $days;
        }

        Booking::create([
            'user_id' => Auth::id(),
            'bookable_id' => $request->bookable_id,
            'bookable_type' => $request->bookable_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_price' => $totalPrice,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'special_requests' => $request->special_requests,
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Booking submitted successfully!');
    }

    public function update(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:255',
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : $startDate;
        $days = $startDate->diffInDays($endDate) ?: 1;

        $totalPrice = 0;
        if ($booking->bookable_type === 'App\Models\Car') {
            $totalPrice = $booking->bookable->daily_rate * $days;
        } else {
            $dailyRate = $booking->bookable->monthly_rate / 30;
            $totalPrice = $dailyRate * $days;
        }

        $booking->update([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_price' => $totalPrice,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'special_requests' => $request->special_requests,
        ]);

        return redirect()->back()->with('success', 'Booking updated successfully!');
    }

    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        
        if ($booking->status === 'pending') {
            $booking->update(['status' => 'cancelled']);
            return redirect()->back()->with('success', 'Booking cancelled successfully!');
        }

        return redirect()->back()->with('error', 'Cannot cancel this booking.');
    }
}
