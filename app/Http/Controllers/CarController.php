<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Car;
use App\Models\CarImage;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $cars = Car::with(['user', 'galleryImages'])->where('verification_status', 'approved')->get();
            $pendingCarsCount = Car::where('verification_status', 'pending')->count();
        } else {
            $cars = Car::with('galleryImages')->where('user_id', $user->id)->get();
            $pendingCarsCount = 0;
        }

        return view('cars.index', compact('cars', 'pendingCarsCount'));
    }

    public function customerIndex(Request $request)
    {
        $query = Car::where('is_available', true);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('brand', 'LIKE', "%{$search}%")
                  ->orWhere('model', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('transmission')) {
            $query->where('transmission', $request->transmission);
        }

        if ($request->filled('price')) {
            $price = $request->price;
            if ($price == '1000') {
                $query->where('daily_rate', '<', 1000);
            } elseif ($price == '3000') {
                $query->whereBetween('daily_rate', [1000, 3000]);
            } elseif ($price == '5000') {
                $query->where('daily_rate', '>', 3000);
            }
        }

        $cars = $query->latest()->paginate(9);
        return view('customer.cars', compact('cars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
            'color' => 'nullable|string|max:255',
            'plate_number' => 'required|string|max:255|unique:cars',
            'capacity' => 'nullable|integer',
            'transmission' => 'nullable|string',
            'fuel_type' => 'nullable|string',
            'daily_rate' => 'required|numeric|min:500|max:20000',
            'security_deposit' => 'required|numeric|min:1000|max:50000',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gallery_photos.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'or_file' => (Auth::user()->role === 'admin') ? 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120' : 'required|file|mimes:jpeg,png,jpg,pdf|max:5120',
            'cr_file' => (Auth::user()->role === 'admin') ? 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120' : 'required|file|mimes:jpeg,png,jpg,pdf|max:5120',
        ]);

        $data = $request->except(['image', 'or_file', 'cr_file', 'gallery_photos']);
        $data['user_id'] = Auth::id();

        if (Auth::user()->role === 'admin') {
            // Admin adds car directly — no approval needed
            $data['verification_status'] = 'approved';
            $data['is_available'] = true;
        } else {
            // Affiliate submits car — must go through admin verification
            $data['verification_status'] = 'pending';
            $data['is_available'] = false;
        }

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/cars'), $imageName);
            $data['image'] = 'images/cars/' . $imageName;
        }

        if ($request->hasFile('or_file')) {
            $data['or_file'] = $request->file('or_file')->store('car-docs', 'public');
        }

        if ($request->hasFile('cr_file')) {
            $data['cr_file'] = $request->file('cr_file')->store('car-docs', 'public');
        }

        $car = Car::create($data);

        if ($request->hasFile('gallery_photos')) {
            $nextOrder = 1;
            foreach ($request->file('gallery_photos') as $photo) {
                $path = ImageHelper::storeAndCompress($photo, 'images/cars/gallery');
                CarImage::create([
                    'car_id' => $car->id,
                    'path'   => $path,
                    'order'  => $nextOrder++,
                ]);
            }
        }

        $message = Auth::user()->role === 'admin'
            ? 'Car listing added and published successfully.'
            : 'Car listing submitted for admin verification.';

        return redirect()->back()->with('success', $message);
    }

    public function update(Request $request, Car $car)
    {
        if (Auth::user()->role !== 'admin' && $car->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
            'color' => 'nullable|string|max:255',
            'plate_number' => 'required|string|max:255|unique:cars,plate_number,' . $car->id,
            'capacity' => 'nullable|integer',
            'transmission' => 'nullable|string',
            'fuel_type' => 'nullable|string',
            'daily_rate' => 'required|numeric|min:500|max:20000',
            'security_deposit' => 'required|numeric|min:1000|max:50000',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'or_file' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
            'cr_file' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
        ]);

        $data = $request->except(['image', 'or_file', 'cr_file']);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($car->image && file_exists(public_path($car->image))) {
                unlink(public_path($car->image));
            }
            
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/cars'), $imageName);
            $data['image'] = 'images/cars/' . $imageName;
        }

        if ($request->hasFile('or_file')) {
            $data['or_file'] = $request->file('or_file')->store('car-docs', 'public');
        }

        if ($request->hasFile('cr_file')) {
            $data['cr_file'] = $request->file('cr_file')->store('car-docs', 'public');
        }

        // If the car was rejected and new documents were uploaded, automatically resend for verification
        if ($car->verification_status === 'rejected' && ($request->hasFile('or_file') || $request->hasFile('cr_file'))) {
            $data['verification_status'] = 'pending';
            $data['rejection_reason'] = null;
        }

        $car->update($data);

        return redirect()->back()->with('success', 'Car updated successfully.');
    }

    public function verificationIndex()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $pendingCars = Car::with('user')
            ->where('verification_status', 'pending')
            ->latest()
            ->get();

        return view('admin.car-verification', compact('pendingCars'));
    }

    public function verify(Request $request, Car $car)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'action' => 'required|in:approve,reject',
            'rejection_reason' => 'required_if:action,reject|nullable|string|max:500',
        ]);

        if ($request->action === 'approve') {
            $car->update([
                'verification_status' => 'approved',
                'is_available' => true,
                'rejection_reason' => null,
            ]);

            // Auto-approve the affiliate if this was their first car and they are still pending
            $carOwner = $car->user;
            if ($carOwner && $carOwner->role === 'affiliate' && $carOwner->status === 'pending') {
                $carOwner->update(['status' => 'approved']);
                if ($carOwner->affiliateDetail) {
                    $carOwner->affiliateDetail->update(['status' => 'approved']);
                }
            }

            return redirect()->back()->with('success', "Car '{$car->brand} {$car->model}' has been approved and is now available.");
        } else {
            $car->update([
                'verification_status' => 'rejected',
                'is_available' => false,
                'rejection_reason' => $request->rejection_reason,
            ]);
            return redirect()->back()->with('success', "Car '{$car->brand} {$car->model}' has been rejected.");
        }
    }

    public function toggleStatus(Car $car)
    {
        if (Auth::user()->role !== 'admin' && $car->user_id !== Auth::id()) {
            abort(403);
        }

        $car->is_available = !$car->is_available;
        $car->save();

        return redirect()->back()->with('success', 'Car status updated.');
    }

    // ── Public detail page (no auth required) ─────────────────────────────────
    public function publicShow(Car $car)
    {
        abort_if(! $car->is_available || $car->verification_status !== 'approved', 404);
        $car->load('galleryImages');
        return view('cars.show', compact('car'));
    }

    // ── Gallery upload (affiliate / admin, authenticated) ──────────────────────
    public function storeGallery(Request $request, Car $car)
    {
        if (Auth::user()->role !== 'admin' && $car->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'photos'   => 'required|array',
            'photos.*' => 'required|image|mimes:jpeg,png,jpg,webp',
        ]);

        $nextOrder = $car->galleryImages()->max('order') + 1;

        foreach ($request->file('photos') as $photo) {
            $path = ImageHelper::storeAndCompress($photo, 'images/cars/gallery');
            CarImage::create([
                'car_id' => $car->id,
                'path'   => $path,
                'order'  => $nextOrder++,
            ]);
        }

        return redirect()->back()->with('success', 'Photos uploaded successfully.');
    }

    // ── Delete a single gallery photo ──────────────────────────────────────────
    public function destroyGalleryImage(CarImage $image)
    {
        $car = $image->car;
        if (Auth::user()->role !== 'admin' && $car->user_id !== Auth::id()) {
            abort(403);
        }

        $filePath = public_path($image->path);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        $image->delete();

        return redirect()->back()->with('success', 'Photo removed.');
    }

    public function destroy(Car $car)
    {
        if (Auth::user()->role !== 'admin' && $car->user_id !== Auth::id()) {
            abort(403);
        }

        // Check for active bookings
        $activeBookings = $car->bookings()->whereIn('status', ['pending', 'confirmed'])->count();
        if ($activeBookings > 0) {
            return redirect()->back()->with('error', 'Cannot delete car while it has active bookings (pending or confirmed).');
        }

        $car->delete();

        return redirect()->back()->with('success', 'Car deleted and moved to history.');
    }
}
