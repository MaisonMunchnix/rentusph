<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Property;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\AffiliateDetail;
use App\Models\Inspection;
use App\Models\User;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            if ($request->get('view') === 'list') {
                $query = Booking::with(['bookable', 'user']);
                
                if ($request->filled('status')) {
                    $query->where('status', $request->status);
                }
                
                if ($request->filled('car_id')) {
                    $query->where('bookable_type', 'App\Models\Car')->where('bookable_id', $request->car_id);
                }

                if ($request->filled('property_id')) {
                    $query->where('bookable_type', 'App\Models\Property')->where('bookable_id', $request->property_id);
                }

                if ($request->filled('search')) {
                    $search = $request->search;
                    $query->where(function($q) use ($search) {
                        $q->where('customer_name', 'LIKE', "%{$search}%")
                          ->orWhere('customer_email', 'LIKE', "%{$search}%");
                    });
                }

                $bookings = $query->latest()->paginate(15);
                $cars = Car::orderBy('brand')->orderBy('model')->get();
                $properties = Property::orderBy('title')->get();
                $customers = User::where('role', 'customer')->orderBy('name')->get();
                
                return view('admin.bookings-list', compact('bookings', 'cars', 'properties', 'customers'));
            }

            $cars = Car::orderBy('brand')->orderBy('model')->get();
            $customers = User::where('role', 'customer')->orderBy('name')->get();
            $properties = Property::orderBy('title')->get();
            return view('admin.bookings', compact('cars', 'customers', 'properties'));
        }

        if ($user->role === 'affiliate') {
            if ($request->get('view') === 'list') {
                $carIds = Car::where('user_id', $user->id)->pluck('id')->toArray();
                $propertyIds = Property::where('user_id', $user->id)->pluck('id')->toArray();

                $bookings = Booking::where(function($q) use ($carIds) {
                        $q->where('bookable_type', 'App\Models\Car')->whereIn('bookable_id', $carIds);
                    })->orWhere(function($q) use ($propertyIds) {
                        $q->where('bookable_type', 'App\Models\Property')->whereIn('bookable_id', $propertyIds);
                    })->with('bookable')->latest()->paginate(15);

                return view('affiliate.bookings-list', compact('bookings'));
            }
            return view('affiliate.bookings');
        }

        $bookings = $user->bookings()->with('bookable')->latest()->get();
        return view('customer.bookings', compact('bookings'));
    }

    public function events()
    {
        try {
            $user = Auth::user();
            $query = Booking::with('bookable', 'user');

            if ($user->role === 'affiliate') {
                $carIds = Car::where('user_id', $user->id)->pluck('id')->toArray();
                $propertyIds = Property::where('user_id', $user->id)->pluck('id')->toArray();

                $query->where(function($q) use ($carIds) {
                    $q->where('bookable_type', 'App\Models\Car')->whereIn('bookable_id', $carIds);
                })->orWhere(function($q) use ($propertyIds) {
                    $q->where('bookable_type', 'App\Models\Property')->whereIn('bookable_id', $propertyIds);
                });
            } elseif ($user->role !== 'admin') {
                abort(403);
            }

            if (request()->filled('car_id')) {
                $query->where('bookable_type', 'App\Models\Car')->where('bookable_id', request()->car_id);
            }

            $bookings = $query->get();

            $colorMap = [
                'pending'   => '#eab308',
                'confirmed' => '#22c55e',
                'cancelled' => '#ef4444',
                'completed' => '#3065D0',
            ];

            $events = $bookings->map(function ($booking) use ($colorMap) {
                $isCar = $booking->bookable_type === 'App\Models\Car';
                
                if (!$booking->bookable) {
                    $name = 'Unknown Item (Deleted)';
                    $image = 'https://placehold.co/600x400?text=Deleted';
                } else {
                    $name = $isCar
                        ? ($booking->bookable->brand ?? '') . ' ' . ($booking->bookable->model ?? '')
                        : ($booking->bookable->title ?? 'N/A');

                    $image = $booking->bookable->image 
                        ? asset($booking->bookable->image) 
                        : 'https://placehold.co/600x400?text=' . urlencode($name);
                }

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
                        'address'       => $booking->customer_address ?? ($booking->user->address ?? null),
                        'item'          => trim($name),
                        'type'          => $isCar ? 'Car' : 'Property',
                        'total'         => '₱' . number_format($booking->total_price, 2),
                        'total_raw'     => $booking->total_price,
                        'special'       => $booking->special_requests,
                        'image_url'     => $image,
                        'proof_url'     => $booking->proof_of_payment ? asset('storage/' . $booking->proof_of_payment) : null,
                        'rental_amount' => $booking->rental_amount,
                        'security_deposit' => $booking->security_deposit,
                        'commission_rate' => $booking->commission_rate ?: 20,
                        'platform_commission' => $booking->platform_commission,
                        'affiliate_earnings' => $booking->affiliate_earnings,
                        'deposit_deducted' => $booking->deposit_deducted,
                        'deposit_refunded' => $booking->deposit_refunded,
                        'inspection' => $booking->inspection ? [
                            'condition' => $booking->inspection->condition,
                            'notes' => $booking->inspection->notes,
                        ] : null,
                    ],
                ];
            });

            return response()->json($events);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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

        $startDate = Carbon::parse($request->start_date);
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : $startDate;

        // Check for overlapping bookings
        $overlap = Booking::where('bookable_id', $request->bookable_id)
            ->where('bookable_type', $request->bookable_type)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate)
                          ->where('end_date', '>=', $endDate);
                    });
            })
            ->exists();

        if ($overlap) {
            return redirect()->back()->withInput()->with('error', 'Sorry, this item is already booked for the selected dates.');
        }

        $bookableClass = $request->bookable_type;
        $bookable = $bookableClass::findOrFail($request->bookable_id);
        
        $days = $startDate->diffInDays($endDate) ?: 1;
        
        $rentalAmount = 0;
        if ($request->bookable_type === 'App\Models\Car') {
            $rentalAmount = $bookable->daily_rate * $days;
        } else {
            $dailyRate = $bookable->monthly_rate / 30;
            $rentalAmount = $dailyRate * $days;
        }

        $securityDeposit = $bookable->security_deposit ?? 3000.00;
        $totalPrice = $rentalAmount + $securityDeposit;

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'bookable_id' => $request->bookable_id,
            'bookable_type' => $request->bookable_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'rental_amount' => $rentalAmount,
            'security_deposit' => $securityDeposit,
            'total_price' => $totalPrice,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'special_requests' => $request->special_requests,
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);

        // Also update the user's address profile if provided
        if ($request->filled('customer_address')) {
            Auth::user()->update(['address' => $request->customer_address]);
        }

        return redirect()->back()
            ->with('booking_success', true)
            ->with('new_booking_id', $booking->id)
            ->with('new_booking_total', number_format($totalPrice, 2));
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
            'customer_address' => 'nullable|string|max:255',
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : $startDate;

        // Check for overlapping bookings (excluding current)
        $overlap = Booking::where('bookable_id', $booking->bookable_id)
            ->where('bookable_type', $booking->bookable_type)
            ->where('id', '!=', $booking->id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate)
                          ->where('end_date', '>=', $endDate);
                    });
            })
            ->exists();

        if ($overlap) {
            return redirect()->back()->withInput()->with('error', 'Sorry, this item is already booked for the selected dates.');
        }

        $days = $startDate->diffInDays($endDate) ?: 1;

        $rentalAmount = 0;
        if ($booking->bookable_type === 'App\Models\Car') {
            $rentalAmount = $booking->bookable->daily_rate * $days;
        } else {
            $dailyRate = $booking->bookable->monthly_rate / 30;
            $rentalAmount = $dailyRate * $days;
        }

        // Keep existing deposit or apply bookable's default
        $securityDeposit = $booking->security_deposit ?? ($booking->bookable->security_deposit ?? 3000.00);
        $totalPrice = $rentalAmount + $securityDeposit;

        $booking->update([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'rental_amount' => $rentalAmount,
            'security_deposit' => $securityDeposit,
            'total_price' => $totalPrice,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'special_requests' => $request->special_requests,
        ]);

        return redirect()->back()->with('success', 'Booking updated successfully!');
    }

    public function destroy(Booking $booking)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized. Only administrators can delete bookings.');
        }

        // Delete associated inspection record if it exists
        if ($booking->inspection) {
            $booking->inspection->delete();
        }

        // Delete proof of payment file if it exists
        if ($booking->proof_of_payment) {
            Storage::disk('public')->delete($booking->proof_of_payment);
        }

        $booking->delete();

        return redirect()->back()->with('success', 'Booking deleted successfully.');
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
        $user = Auth::user();
        
        // Authorization check
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized. Only administrators can update booking status.');
        }

        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'inspection_condition' => 'nullable|in:good,damaged',
            'inspection_notes' => 'nullable|string',
            'rental_amount' => 'required_if:status,confirmed|nullable|numeric',
            'security_deposit' => 'required_if:status,confirmed|nullable|numeric',
            'deposit_deducted' => 'nullable|numeric|min:0',
        ]);

        $updateData = ['status' => $request->status];

        if ($request->status === 'confirmed') {
            $rentalAmount = (float) $request->rental_amount;
            $securityDeposit = (float) $request->security_deposit;

            // Compute commission and earnings
            $commissionRate = 20.00; // Default 20%
            $owner = $booking->bookable?->user;
            if ($owner) {
                $detail = AffiliateDetail::where('user_id', $owner->id)->first();
                if ($detail && $detail->commission_rate) {
                    $commissionRate = (float) $detail->commission_rate;
                }
            }

            $commission = round($rentalAmount * ($commissionRate / 100), 2);
            $affiliateEarnings = round($rentalAmount - $commission, 2);

            $updateData = array_merge($updateData, [
                'rental_amount' => $rentalAmount,
                'security_deposit' => $securityDeposit,
                'total_price' => $rentalAmount + $securityDeposit,
                'commission_rate' => $commissionRate,
                'platform_commission' => $commission,
                'affiliate_earnings' => $affiliateEarnings,
            ]);
        }

        if ($request->status === 'completed') {
            $deducted = 0;
            if ($request->inspection_condition === 'damaged') {
                $deducted = (float) ($booking->security_deposit ?? 0);
            }
            $refunded = (float) ($booking->security_deposit ?? 0) - $deducted;

            $updateData['deposit_deducted'] = $deducted;
            $updateData['deposit_refunded'] = $refunded;

            // Damage deductions go to the affiliate (owner) to cover repair costs
            if ($deducted > 0) {
                $currentEarnings = $booking->affiliate_earnings ?? 0;
                $updateData['affiliate_earnings'] = $currentEarnings + $deducted;
            }

            // Save inspection
            Inspection::updateOrCreate(
                ['booking_id' => $booking->id],
                [
                    'condition' => $request->inspection_condition,
                    'notes' => $request->inspection_notes,
                ]
            );
        }

        $booking->update($updateData);

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

    public function getTakenDates(Request $request)
    {
        $request->validate([
            'bookable_id' => 'required|integer',
            'bookable_type' => 'required|string',
        ]);

        $bookings = Booking::where('bookable_id', $request->bookable_id)
            ->where('bookable_type', $request->bookable_type)
            ->where('status', '!=', 'cancelled')
            ->get(['start_date', 'end_date']);

        $takenDates = [];
        foreach ($bookings as $booking) {
            $startDate = Carbon::parse($booking->start_date);
            $endDate = Carbon::parse($booking->end_date);
            
            $period = CarbonPeriod::create($startDate, $endDate);
            foreach ($period as $date) {
                $takenDates[] = $date->format('Y-m-d');
            }
        }

        return response()->json(array_unique($takenDates));
    }

    public function manualStore(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'bookable_id' => 'required',
            'bookable_type' => 'required|in:App\Models\Car,App\Models\Property',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'customer_type' => 'required|in:existing,new',
            'user_id' => 'required_if:customer_type,existing|nullable|exists:users,id',
            'customer_name' => 'required_if:customer_type,new|nullable|string|max:255',
            'customer_email' => 'required_if:customer_type,new|nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:255',
            'status' => 'required|in:pending,confirmed',
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : $startDate;

        // Check for overlapping bookings
        $overlap = Booking::where('bookable_id', $request->bookable_id)
            ->where('bookable_type', $request->bookable_type)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate)
                          ->where('end_date', '>=', $endDate);
                    });
            })
            ->exists();

        if ($overlap) {
            return response()->json(['error' => 'This item is already booked for the selected dates.'], 422);
        }

        $bookableClass = $request->bookable_type;
        $bookable = $bookableClass::findOrFail($request->bookable_id);
        
        $days = $startDate->diffInDays($endDate) ?: 1;
        
        $rentalAmount = 0;
        if ($request->bookable_type === 'App\Models\Car') {
            $rentalAmount = (float)($request->rental_amount ?? ($bookable->daily_rate * $days));
        } else {
            $dailyRate = $bookable->monthly_rate / 30;
            $rentalAmount = (float)($request->rental_amount ?? ($dailyRate * $days));
        }

        $securityDeposit = (float)($request->security_deposit ?? ($bookable->security_deposit ?? 3000.00));
        $totalPrice = $rentalAmount + $securityDeposit;

        $bookingData = [
            'bookable_id' => $request->bookable_id,
            'bookable_type' => $request->bookable_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'rental_amount' => $rentalAmount,
            'security_deposit' => $securityDeposit,
            'total_price' => $totalPrice,
            'status' => $request->status,
            'payment_status' => $request->status === 'confirmed' ? 'paid' : 'pending',
        ];

        if ($request->customer_type === 'existing') {
            $customer = User::findOrFail($request->user_id);
            $bookingData['user_id'] = $customer->id;
            $bookingData['customer_name'] = $customer->name;
            $bookingData['customer_email'] = $customer->email;
            $bookingData['customer_phone'] = $customer->phone;
            $bookingData['customer_address'] = $customer->address;
        } else {
            $bookingData['user_id'] = Auth::id(); // Admin booked it
            $bookingData['customer_name'] = $request->customer_name;
            $bookingData['customer_email'] = $request->customer_email;
            $bookingData['customer_phone'] = $request->customer_phone;
            $bookingData['customer_address'] = $request->customer_address;
        }

        // Commission calculation if confirmed
        if ($request->status === 'confirmed') {
            $commissionRate = 20.00;
            $owner = $bookable->user;
            if ($owner) {
                $detail = AffiliateDetail::where('user_id', $owner->id)->first();
                if ($detail && $detail->commission_rate) {
                    $commissionRate = (float) $detail->commission_rate;
                }
            }
            $commission = round($rentalAmount * ($commissionRate / 100), 2);
            $affiliateEarnings = round($rentalAmount - $commission, 2);

            $bookingData['commission_rate'] = $commissionRate;
            $bookingData['platform_commission'] = $commission;
            $bookingData['affiliate_earnings'] = $affiliateEarnings;
        }

        Booking::create($bookingData);

        return response()->json(['success' => 'Manual booking created successfully!']);
    }
}
