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
    return view('dashboard.index');
})->name('dashboard');

// Authentication API / Endpoints
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth');
