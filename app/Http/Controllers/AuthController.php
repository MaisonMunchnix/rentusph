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

        // Check for pending car or property booking intent
        $pendingCarId = session('pending_car_id');
        $pendingPropertyId = session('pending_property_id');
        session()->forget('pending_car_id');
        session()->forget('pending_property_id');

        if ($user->role === 'affiliate') {
            return redirect('/pending-review');
        }

        if ($pendingCarId) {
            return redirect()->route('customer.explore', ['intent_car' => $pendingCarId]);
        }
        
        if ($pendingPropertyId) {
            return redirect()->route('customer.explore', ['intent_property' => $pendingPropertyId]);
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

            // Check for pending car or property booking intent
            $pendingCarId = session('pending_car_id');
            $pendingPropertyId = session('pending_property_id');
            session()->forget('pending_car_id');
            session()->forget('pending_property_id');

            if (Auth::user()->role === 'customer') {
                if ($pendingCarId) {
                    return redirect()->route('customer.explore', ['intent_car' => $pendingCarId]);
                }
                
                if ($pendingPropertyId) {
                    return redirect()->route('customer.explore', ['intent_property' => $pendingPropertyId]);
                }
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

    /**
     * Step 1: Verify the email exists, then store it in session and
     * redirect to the set-new-password form. No email is sent.
     */
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->withErrors(['email' => 'No account found with that email address.'])
                ->withInput();
        }

        // Store the verified email in session so the reset form can use it
        session(['reset_email' => $user->email]);

        return redirect()->route('password.reset.form');
    }

    /**
     * Step 2: Show the set-new-password form.
     * Guard against direct access without going through Step 1.
     */
    public function showResetForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Please enter your email first.']);
        }

        return view('auth.reset-password');
    }

    /**
     * Step 3: Update the password directly in the database.
     */
    public function resetPassword(Request $request)
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request');
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::where('email', session('reset_email'))
            ->update(['password' => Hash::make($request->password)]);

        session()->forget('reset_email');

        return redirect()->route('login')
            ->with('status', 'Password updated successfully. You can now sign in.');
    }
}
