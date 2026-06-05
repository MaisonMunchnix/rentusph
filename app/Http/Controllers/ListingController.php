<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type', 'all');
        $search = $request->input('search');
        $priceRange = $request->input('price');

        $listings = collect();

        if ($type === 'all' || $type === 'car') {
            $carQuery = Car::where('is_available', true);
            
            if ($search) {
                $carQuery->where(function($q) use ($search) {
                    $q->where('brand', 'LIKE', "%{$search}%")
                      ->orWhere('model', 'LIKE', "%{$search}%");
                });
            }

            if ($priceRange) {
                if ($priceRange == '1000') {
                    $carQuery->where('daily_rate', '<', 1000);
                } elseif ($priceRange == '3000') {
                    $carQuery->whereBetween('daily_rate', [1000, 3000]);
                } elseif ($priceRange == '5000') {
                    $carQuery->where('daily_rate', '>', 3000);
                }
            }

            $cars = $carQuery->latest()->get()->map(function($item) {
                $item->listing_type = 'car';
                return $item;
            });
            $listings = $listings->concat($cars);
        }

        if ($type === 'all' || $type === 'property') {
            $propQuery = Property::where('is_available', true);

            if ($search) {
                $propQuery->where(function($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                      ->orWhere('city', 'LIKE', "%{$search}%")
                      ->orWhere('region', 'LIKE', "%{$search}%");
                });
            }

            if ($priceRange) {
                // Properties have higher price ranges usually, but let's try to map them or keep them separate in UI
                // For "All", maybe price filtering is tricky. 
                // Let's use the property price logic if type is property or both.
                if ($priceRange == '10000') {
                    $propQuery->where('monthly_rate', '<', 10000);
                } elseif ($priceRange == '30000') {
                    $propQuery->whereBetween('monthly_rate', [10000, 30000]);
                } elseif ($priceRange == '50000') {
                    $propQuery->where('monthly_rate', '>', 30000);
                }
            }

            $properties = $propQuery->latest()->get()->map(function($item) {
                $item->listing_type = 'property';
                return $item;
            });
            $listings = $listings->concat($properties);
        }

        // Sort by created_at descending
        $listings = $listings->sortByDesc('created_at');

        // Manual Pagination
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 12;
        $currentItems = $listings->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedListings = new LengthAwarePaginator($currentItems, $listings->count(), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'query' => $request->query(),
        ]);

        $intentCar = null;
        if ($request->has('intent_car')) {
            $intentCar = Car::find($request->intent_car);
        }

        return view('customer.explore-listings', [
            'listings' => $paginatedListings,
            'type' => $type,
            'intentCar' => $intentCar
        ]);
    }
}
