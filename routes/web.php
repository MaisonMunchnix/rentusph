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

// Admin Dashboard
Route::get('/dashboard', function () {
    return view('admin.index');
})->name('admin');

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
});

// Authentication API / Endpoints
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth');
