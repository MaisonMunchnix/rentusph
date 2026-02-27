<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication Views
Route::get('/login', function () { return view('auth.login'); })->name('login');
Route::get('/register/customer', function () { return view('auth.customer-registration'); })->name('register.customer');
Route::get('/register/affiliate', function () { return view('auth.affiliate-registration'); })->name('register.affiliate');
Route::get('/forgot-password', function () { return view('auth.forgot-password'); })->name('password.request');

// Role-based Dashboard
Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return view('admin.index');
    } elseif (Auth::user()->role === 'customer') {
        return view('customer.index');
    } elseif (Auth::user()->role === 'affiliate') {
        return view('affiliate.index');
    }
    
    // Fallback for unrecognized roles
    return redirect()->route('login');
})->name('dashboard')->middleware(['auth', 'affiliate.status']);

// Admin Dashboard Redirect (legacy name support)
Route::get('/admin-dashboard', function() {
    return redirect()->route('dashboard');
})->name('admin');

// Pending Affiliate View
Route::get('/pending-review', function () {
    return view('pending-affiliate.index');
})->middleware('auth')->name('pending-review');

// Car Management (Protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/cars', [\App\Http\Controllers\CarController::class, 'index'])->name('cars.index');
    Route::post('/cars', [\App\Http\Controllers\CarController::class, 'store'])->name('cars.store');
    Route::put('/cars/{car}', [\App\Http\Controllers\CarController::class, 'update'])->name('cars.update');
    Route::delete('/cars/{car}', [\App\Http\Controllers\CarController::class, 'destroy'])->name('cars.destroy');
    Route::patch('/cars/{car}/toggle-status', [\App\Http\Controllers\CarController::class, 'toggleStatus'])->name('cars.toggle-status');

    // Property Management
    Route::get('/properties', [\App\Http\Controllers\PropertyController::class, 'index'])->name('properties.index');
    Route::post('/properties', [\App\Http\Controllers\PropertyController::class, 'store'])->name('properties.store');
    Route::put('/properties/{property}', [\App\Http\Controllers\PropertyController::class, 'update'])->name('properties.update');
    Route::delete('/properties/{property}', [\App\Http\Controllers\PropertyController::class, 'destroy'])->name('properties.destroy');
    Route::patch('/properties/{property}/toggle-status', [\App\Http\Controllers\PropertyController::class, 'toggleStatus'])->name('properties.toggle-status');

    // Booking Management
    Route::get('/bookings', function () {
        if (auth()->user()->role === 'customer') {
            // In a real app, we would pass $bookings here
            $bookings = auth()->user()->bookings ?? collect([]);
            return view('customer.bookings', compact('bookings'));
        }
        return view('booking.index');
    })->name('bookings.index');

    // Affiliate Management
    Route::get('/affiliate-management', [\App\Http\Controllers\AffiliateManagementController::class, 'index'])->name('affiliates.index');
    Route::post('/affiliates', [\App\Http\Controllers\AffiliateManagementController::class, 'store'])->name('affiliates.store');
    Route::patch('/affiliates/{user}/approve', [\App\Http\Controllers\AffiliateManagementController::class, 'approve'])->name('affiliates.approve');
    Route::patch('/affiliates/{user}/reject', [\App\Http\Controllers\AffiliateManagementController::class, 'reject'])->name('affiliates.reject');
    Route::delete('/affiliates/{user}', [\App\Http\Controllers\AffiliateManagementController::class, 'destroy'])->name('affiliates.destroy');

    // Admin Reports
    Route::get('/admin/reports', function () {
        return view('admin.reports');
    })->name('admin.reports');
});

// Authentication API / Endpoints
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
