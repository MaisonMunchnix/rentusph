<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyImage;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $properties = Property::with(['user', 'galleryImages'])->get();
        } else {
            $properties = Property::with('galleryImages')->where('user_id', $user->id)->get();
        }

        return view('properties.index', compact('properties'));
    }

    public function customerIndex(Request $request)
    {
        $query = Property::where('is_available', true);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('city', 'LIKE', "%{$search}%")
                  ->orWhere('region', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('price')) {
            $price = $request->price;
            if ($price == '10000') {
                $query->where('monthly_rate', '<', 10000);
            } elseif ($price == '30000') {
                $query->whereBetween('monthly_rate', [10000, 30000]);
            } elseif ($price == '50000') {
                $query->where('monthly_rate', '>', 30000);
            }
        }

        $properties = $query->latest()->paginate(9);
        return view('customer.properties', compact('properties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'monthly_rate' => 'required|numeric',
            'security_deposit' => 'required|numeric',
            'rate_type' => 'required|string|in:daily,monthly',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except('image');
        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/properties'), $imageName);
            $data['image'] = 'images/properties/' . $imageName;
        }

        Property::create($data);

        return redirect()->back()->with('success', 'Property added successfully.');
    }

    public function update(Request $request, Property $property)
    {
        if (Auth::user()->role !== 'admin' && $property->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'monthly_rate' => 'required|numeric',
            'security_deposit' => 'required|numeric',
            'rate_type' => 'required|string|in:daily,monthly',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($property->image && file_exists(public_path($property->image))) {
                unlink(public_path($property->image));
            }
            
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/properties'), $imageName);
            $data['image'] = 'images/properties/' . $imageName;
        }

        $property->update($data);

        return redirect()->back()->with('success', 'Property updated successfully.');
    }

    public function toggleStatus(Property $property)
    {
        if (Auth::user()->role !== 'admin' && $property->user_id !== Auth::id()) {
            abort(403);
        }

        $property->is_available = !$property->is_available;
        $property->save();

        return redirect()->back()->with('success', 'Property status updated.');
    }

    // ── Public detail page (no auth required) ─────────────────────────────────
    public function publicShow(Property $property)
    {
        abort_if(! $property->is_available, 404);
        $property->load('galleryImages');
        return view('properties.show', compact('property'));
    }

    // ── Gallery upload (affiliate / admin, authenticated) ──────────────────────
    public function storeGallery(Request $request, Property $property)
    {
        if (Auth::user()->role !== 'admin' && $property->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'photos'   => 'required|array',
            'photos.*' => 'required|image|mimes:jpeg,png,jpg,webp',
        ]);

        $nextOrder = $property->galleryImages()->max('order') + 1;

        foreach ($request->file('photos') as $photo) {
            $path = ImageHelper::storeAndCompress($photo, 'images/properties/gallery');
            PropertyImage::create([
                'property_id' => $property->id,
                'path'        => $path,
                'order'       => $nextOrder++,
            ]);
        }

        return redirect()->back()->with('success', 'Photos uploaded successfully.');
    }

    // ── Delete a single gallery photo ──────────────────────────────────────────
    public function destroyGalleryImage(PropertyImage $image)
    {
        $property = $image->property;
        if (Auth::user()->role !== 'admin' && $property->user_id !== Auth::id()) {
            abort(403);
        }

        $filePath = public_path($image->path);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        $image->delete();

        return redirect()->back()->with('success', 'Photo removed.');
    }

    public function destroy(Property $property)
    {
        if (Auth::user()->role !== 'admin' && $property->user_id !== Auth::id()) {
            abort(403);
        }

        // Check for active bookings
        $activeBookings = $property->bookings()->whereIn('status', ['pending', 'confirmed'])->count();
        if ($activeBookings > 0) {
            return redirect()->back()->with('error', 'Cannot delete property while it has active bookings (pending or confirmed).');
        }

        $property->delete();

        return redirect()->back()->with('success', 'Property deleted and moved to history.');
    }
}
