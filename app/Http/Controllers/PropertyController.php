<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $properties = Property::with('user')->get();
        } else {
            $properties = Property::where('user_id', $user->id)->get();
        }

        return view('properties.index', compact('properties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'monthly_rate' => 'required|numeric',
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

    public function destroy(Property $property)
    {
        if (Auth::user()->role !== 'admin' && $property->user_id !== Auth::id()) {
            abort(403);
        }

        $property->delete();

        return redirect()->back()->with('success', 'Property deleted successfully.');
    }
}
