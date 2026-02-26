<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Car;
use Illuminate\Support\Facades\Auth;

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
        ]);

        Car::create(array_merge($request->all(), ['user_id' => Auth::id()]));

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
        ]);

        $car->update($request->all());

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
