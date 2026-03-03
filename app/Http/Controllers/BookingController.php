<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Property;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role === 'admin') {
            $query = Booking::with(['bookable', 'user'])->latest();

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('type')) {
                $query->where('bookable_type', $request->type === 'car' ? 'App\Models\Car' : 'App\Models\Property');
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('customer_name', 'LIKE', "%{$search}%")
                      ->orWhere('customer_email', 'LIKE', "%{$search}%");
                });
            }

            $bookings = $query->paginate(15);
            return view('admin.bookings', compact('bookings'));
        }

        $bookings = Auth::user()->bookings()->with('bookable')->latest()->get();
        return view('customer.bookings', compact('bookings'));
    }

    public function events()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $bookings = Booking::with('bookable')->get();

        $colorMap = [
            'pending'   => '#eab308',
            'confirmed' => '#22c55e',
            'cancelled' => '#ef4444',
            'completed' => '#3b82f6',
        ];

        $events = $bookings->map(function ($booking) use ($colorMap) {
            $isCar = $booking->bookable_type === 'App\Models\Car';
            $name = $isCar
                ? ($booking->bookable->brand ?? '') . ' ' . ($booking->bookable->model ?? '')
                : ($booking->bookable->title ?? 'N/A');

            return [
                'id'    => $booking->id,
                'title' => $booking->customer_name . ' — ' . trim($name),
                'start' => $booking->start_date,
                'end'   => $booking->end_date
                    ? \Carbon\Carbon::parse($booking->end_date)->addDay()->format('Y-m-d')
                    : null,
                'color'           => $colorMap[$booking->status] ?? '#6b7280',
                'extendedProps'   => [
                    'status'        => $booking->status,
                    'customer'      => $booking->customer_name,
                    'email'         => $booking->customer_email,
                    'phone'         => $booking->customer_phone,
                    'item'          => trim($name),
                    'type'          => $isCar ? 'Car' : 'Property',
                    'total'         => '₱' . number_format($booking->total_price, 2),
                    'special'       => $booking->special_requests,
                ],
            ];
        });

        return response()->json($events);
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

    public function updateStatus(Request $request, Booking $booking)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $booking->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Booking status updated to ' . ucfirst($request->status) . '.');
    }

    public function uploadProof(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'proof_of_payment' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        if ($request->hasFile('proof_of_payment')) {
            // Delete old proof if it exists
            if ($booking->proof_of_payment) {
                Storage::disk('public')->delete($booking->proof_of_payment);
            }

            $path = $request->file('proof_of_payment')->store('proofs', 'public');
            $booking->update(['proof_of_payment' => $path]);
        }

        return redirect()->back()->with('success', 'Proof of payment uploaded successfully!');
    }

    public function payments()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $bookings = Booking::with(['bookable', 'user'])->latest()->paginate(15);
        return view('admin.payments', compact('bookings'));
    }
}
