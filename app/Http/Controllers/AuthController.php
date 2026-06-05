<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:affiliate,customer',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $status = $request->role === 'affiliate' ? 'pending' : 'approved';

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => $status,
        ]);

        if ($user->role === 'affiliate') {
            \App\Models\AffiliateDetail::create([
                'user_id' => $user->id,
                'status' => 'pending',
                'vehicles_submitted' => false,
            ]);
        }

        Auth::login($user);

        // Check for pending car booking intent
        $pendingCarId = session('pending_car_id');
        session()->forget('pending_car_id');

        if ($user->role === 'affiliate') {
            return redirect('/pending-review');
        }

        if ($pendingCarId) {
            return redirect()->route('customer.explore', ['intent_car' => $pendingCarId]);
        }

        return redirect()->intended('/dashboard');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            // Check for pending car booking intent
            $pendingCarId = session('pending_car_id');
            session()->forget('pending_car_id');

            if ($pendingCarId && Auth::user()->role === 'customer') {
                return redirect()->route('customer.explore', ['intent_car' => $pendingCarId]);
            }

            return redirect()->intended('/dashboard');
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials do not match our records.'],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
