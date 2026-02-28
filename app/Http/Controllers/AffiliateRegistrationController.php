<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\AffiliateDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AffiliateRegistrationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role !== 'affiliate') {
            return redirect('/dashboard');
        }

        $detail = $user->affiliateDetail;
        
        // If they are somehow missing the detail record, create it
        if (!$detail) {
            $detail = AffiliateDetail::create([
                'user_id' => $user->id,
                'status' => 'pending',
                'vehicles_submitted' => false,
            ]);
        }

        // If already approved, they shouldn't be here (middleware handles this usually)
        if ($detail->status === 'approved') {
            return redirect('/dashboard');
        }

        return view('pending-affiliate.index', [
            'vehicles_submitted' => $detail->vehicles_submitted,
            'status' => $detail->status
        ]);
    }

    public function storeVehicles(Request $request)
    {
        $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'plate_number' => 'required|string|unique:cars,plate_number',
            'daily_rate' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images/cars'), $imageName);
            $imagePath = 'images/cars/' . $imageName;
        }

        Car::create([
            'user_id' => $user->id,
            'brand' => $request->brand,
            'model' => $request->model,
            'year' => $request->year,
            'plate_number' => $request->plate_number,
            'daily_rate' => $request->daily_rate,
            'image' => $imagePath,
            'is_available' => false, // Keep unavailable until approved
        ]);

        AffiliateDetail::updateOrCreate(
            ['user_id' => $user->id],
            ['vehicles_submitted' => true]
        );

        return redirect()->route('pending-review')->with('success', 'Vehicle submitted successfully. Your application is now under review.');
    }
}
