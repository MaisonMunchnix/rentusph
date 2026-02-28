<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Car;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $cars = Car::with('user')->get();
        } else {
            $cars = Car::where('user_id', $user->id)->get();
        }

        return view('cars.index', compact('cars'));
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
            'daily_rate' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except('image');
        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/cars'), $imageName);
            $data['image'] = 'images/cars/' . $imageName;
        }

        Car::create($data);

        return redirect()->back()->with('success', 'Car added successfully.');
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
            'daily_rate' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($car->image && file_exists(public_path($car->image))) {
                unlink(public_path($car->image));
            }
            
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/cars'), $imageName);
            $data['image'] = 'images/cars/' . $imageName;
        }

        $car->update($data);

        return redirect()->back()->with('success', 'Car updated successfully.');
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

    public function destroy(Car $car)
    {
        if (Auth::user()->role !== 'admin' && $car->user_id !== Auth::id()) {
            abort(403);
        }

        $car->delete();

        return redirect()->back()->with('success', 'Car deleted successfully.');
    }
}
