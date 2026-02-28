<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AffiliateDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AffiliateManagementController extends Controller
{
    /**
     * Display a listing of the affiliates.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $affiliates = User::where('role', 'affiliate')->with('affiliateDetail')->get();
        return view('admin.affiliate', compact('affiliates'));
    }

    /**
     * Store a newly created affiliate in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'affiliate',
            'status' => 'approved', // Legacy status
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        AffiliateDetail::create([
            'user_id' => $user->id,
            'status' => 'approved',
            'vehicles_submitted' => true,
        ]);

        return redirect()->back()->with('success', 'Affiliate added successfully.');
    }

    /**
     * Approve an affiliate account.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(User $user)
    {
        $user->affiliateDetail()->updateOrCreate(
            ['user_id' => $user->id],
            ['status' => 'approved']
        );
        $user->update(['status' => 'approved']); // Sync legacy status
        return redirect()->back()->with('success', 'Affiliate approved successfully.');
    }

    /**
     * Reject an affiliate account.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject(User $user)
    {
        $user->affiliateDetail()->updateOrCreate(
            ['user_id' => $user->id],
            ['status' => 'rejected']
        );
        $user->update(['status' => 'rejected']); // Sync legacy status
        return redirect()->back()->with('success', 'Affiliate rejected successfully.');
    }

    /**
     * Remove the specified affiliate from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'Affiliate deleted successfully.');
    }
}
