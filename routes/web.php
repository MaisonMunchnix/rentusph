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
  $cars = \App\Models\Car::where('is_available', true)->latest()->take(6)->get();
  $properties = \App\Models\Property::where('is_available', true)->latest()->take(6)->get();
  return view('welcome', compact('cars', 'properties'));
});

Route::get('/public/cars', function () {
  $cars = \App\Models\Car::where('is_available', true)->latest()->paginate(12);
  return view('cars', compact('cars'));
})->name('public.cars');

Route::get('/public/cars/{car}', [\App\Http\Controllers\CarController::class, 'publicShow'])->name('public.cars.show');

Route::get('/public/properties', function () {
  $properties = \App\Models\Property::where('is_available', true)->latest()->paginate(12);
  return view('properties', compact('properties'));
})->name('public.properties');

Route::get('/public/properties/{property}', [\App\Http\Controllers\PropertyController::class, 'publicShow'])->name('public.properties.show');

Route::get('/about', function () {
  return view('about');
})->name('public.about');

// Authentication Views
Route::get('/login', function (\Illuminate\Http\Request $request) {
  // Clear intent if user explicitly navigates to general login/register
  if ($request->has('clear_intent')) {
      session()->forget('pending_car_id');
  }
  // Store car_id in session if coming from a car booking intent
  if ($request->car_id) {
    session(['pending_car_id' => (int) $request->car_id]);
  }
  $selectedCar = session('pending_car_id')
    ? \App\Models\Car::find(session('pending_car_id'))
    : null;
  return view('auth.login', compact('selectedCar'));
})->name('login');

Route::get('/register/customer', function (\Illuminate\Http\Request $request) {
  // Clear intent if user explicitly navigates to general login/register
  if ($request->has('clear_intent')) {
      session()->forget('pending_car_id');
  }
  // Store car_id in session if coming from a car booking intent
  if ($request->car_id) {
    session(['pending_car_id' => (int) $request->car_id]);
  }
  $selectedCar = session('pending_car_id')
    ? \App\Models\Car::find(session('pending_car_id'))
    : null;
  return view('auth.customer-registration', compact('selectedCar'));
})->name('register.customer');
Route::get('/register/affiliate', function () {
  return view('auth.affiliate-registration');
})->name('register.affiliate');
Route::get('/forgot-password', function () {
  return view('auth.forgot-password');
})->name('password.request');

// Role-based Dashboard
Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware(['auth', 'affiliate.status']);

// Admin Dashboard Redirect (legacy name support)
Route::get('/admin-dashboard', function () {
  return redirect()->route('dashboard');
})->name('admin');

// Pending Affiliate View
Route::get('/pending-review', [\App\Http\Controllers\AffiliateRegistrationController::class, 'index'])->middleware('auth')->name('pending-review');
Route::post('/pending-review/vehicles', [\App\Http\Controllers\AffiliateRegistrationController::class, 'storeVehicles'])->middleware('auth')->name('pending-review.vehicles');

// Customer Browsing Routes
Route::middleware(['auth'])->group(function () {
  Route::get('/explore-listings', [\App\Http\Controllers\ListingController::class, 'index'])->name('customer.explore');
  Route::get('/customer/profile', [\App\Http\Controllers\CustomerProfileController::class, 'index'])->name('customer.profile');
  Route::put('/customer/profile', [\App\Http\Controllers\CustomerProfileController::class, 'update'])->name('customer.profile.update');
});

// Car Management (Protected)
Route::middleware(['auth'])->group(function () {
  Route::get('/cars', [\App\Http\Controllers\CarController::class, 'index'])->name('cars.index');
  Route::post('/cars', [\App\Http\Controllers\CarController::class, 'store'])->name('cars.store');
  Route::put('/cars/{car}', [\App\Http\Controllers\CarController::class, 'update'])->name('cars.update');
  Route::delete('/cars/{car}', [\App\Http\Controllers\CarController::class, 'destroy'])->name('cars.destroy');
  Route::patch('/cars/{car}/toggle-status', [\App\Http\Controllers\CarController::class, 'toggleStatus'])->name('cars.toggle-status');
  Route::get('/admin/car-verification', [\App\Http\Controllers\CarController::class, 'verificationIndex'])->name('admin.car-verification');
  Route::patch('/cars/{car}/verify', [\App\Http\Controllers\CarController::class, 'verify'])->name('cars.verify');
  Route::post('/cars/{car}/gallery', [\App\Http\Controllers\CarController::class, 'storeGallery'])->name('cars.gallery.store');
  Route::delete('/cars/gallery/{image}', [\App\Http\Controllers\CarController::class, 'destroyGalleryImage'])->name('cars.gallery.destroy');

  // Property Management
  Route::get('/properties', [\App\Http\Controllers\PropertyController::class, 'index'])->name('properties.index');
  Route::post('/properties', [\App\Http\Controllers\PropertyController::class, 'store'])->name('properties.store');
  Route::put('/properties/{property}', [\App\Http\Controllers\PropertyController::class, 'update'])->name('properties.update');
  Route::delete('/properties/{property}', [\App\Http\Controllers\PropertyController::class, 'destroy'])->name('properties.destroy');
  Route::patch('/properties/{property}/toggle-status', [\App\Http\Controllers\PropertyController::class, 'toggleStatus'])->name('properties.toggle-status');
  Route::post('/properties/{property}/gallery', [\App\Http\Controllers\PropertyController::class, 'storeGallery'])->name('properties.gallery.store');
  Route::delete('/properties/gallery/{image}', [\App\Http\Controllers\PropertyController::class, 'destroyGalleryImage'])->name('properties.gallery.destroy');

  // Booking Management
  Route::get('/bookings', [\App\Http\Controllers\BookingController::class, 'index'])->name('bookings.index');
  Route::get('/bookings/events', [\App\Http\Controllers\BookingController::class, 'events'])->name('bookings.events');
  Route::post('/bookings', [\App\Http\Controllers\BookingController::class, 'store'])->name('bookings.store');
  Route::post('/admin/bookings/manual', [\App\Http\Controllers\BookingController::class, 'manualStore'])->name('admin.bookings.manual');
  Route::put('/bookings/{booking}', [\App\Http\Controllers\BookingController::class, 'update'])->name('bookings.update');
  Route::delete('/bookings/{booking}', [\App\Http\Controllers\BookingController::class, 'destroy'])->name('bookings.destroy');
  Route::delete('/bookings/{booking}/cancel', [\App\Http\Controllers\BookingController::class, 'cancel'])->name('bookings.cancel');
  Route::patch('/bookings/{booking}/status', [\App\Http\Controllers\BookingController::class, 'updateStatus'])->name('bookings.status');
  Route::get('/bookings/taken-dates', [\App\Http\Controllers\BookingController::class, 'getTakenDates'])->name('bookings.taken-dates');
  Route::post('/bookings/{booking}/proof', [\App\Http\Controllers\BookingController::class, 'uploadProof'])->name('bookings.proof');

  // Affiliate Management
  Route::get('/affiliate-management', [\App\Http\Controllers\AffiliateManagementController::class, 'index'])->name('affiliates.index');
  Route::post('/affiliates', [\App\Http\Controllers\AffiliateManagementController::class, 'store'])->name('affiliates.store');
  Route::patch('/affiliates/{user}/approve', [\App\Http\Controllers\AffiliateManagementController::class, 'approve'])->name('affiliates.approve');
  Route::patch('/affiliates/{user}/reject', [\App\Http\Controllers\AffiliateManagementController::class, 'reject'])->name('affiliates.reject');
  Route::delete('/affiliates/{user}', [\App\Http\Controllers\AffiliateManagementController::class, 'destroy'])->name('affiliates.destroy');

  // Admin Reports
  Route::get('/admin/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('admin.reports');

  // Admin Profile
  Route::get('/admin/profile', [\App\Http\Controllers\AdminProfileController::class, 'index'])->name('admin.profile');
  Route::put('/admin/profile', [\App\Http\Controllers\AdminProfileController::class, 'update'])->name('admin.profile.update');

  // Admin Payments
  Route::get('/admin/payments', [\App\Http\Controllers\BookingController::class, 'payments'])->name('admin.payments');

  // Customer Management
  Route::get('/admin/customers', function () {
    $customers = \App\Models\User::where('role', 'customer')->latest()->get();
    return view('admin.customers', compact('customers'));
  })->name('admin.customers');

  // Affiliate Earnings
  Route::get('/affiliate/earnings', [\App\Http\Controllers\AffiliateEarningsController::class, 'index'])->name('affiliate.earnings');
});

// Authentication API / Endpoints
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);


Route::get('/create-symlink', function () {
  $docRoot = $_SERVER['DOCUMENT_ROOT'];

  // 1. Delete the bad infinite-loop shortcut we just made
  if (is_link($docRoot . '/storage')) {
    unlink($docRoot . '/storage');
  }

  // 2. Find the backup folder we made and rename it back to 'storage'
  $files = scandir($docRoot);
  foreach ($files as $file) {
    if (strpos($file, 'storage_old_backup_') === 0) {
      rename($docRoot . '/' . $file, $docRoot . '/storage');
      return 'Rescue successful! Your storage folder has been restored.';
    }
  }

  return 'Could not find the backup folder. You may need to rename it manually in cPanel.';
});
