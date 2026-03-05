<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\Booking;
use App\Models\Car;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Share counts with the admin sidebar
        View::composer('components.admin.sidebar', function ($view) {
            $pendingAffiliatesCount = User::where('role', 'affiliate')
                ->where('status', 'pending')
                ->count();
            
            $pendingBookingsCount = Booking::where('status', 'pending')->count();

            $view->with([
                'pendingAffiliatesCount' => $pendingAffiliatesCount,
                'pendingBookingsCount' => $pendingBookingsCount
            ]);
        });

        // Share pending bookings count with the affiliate sidebar
        View::composer('components.affiliate.sidebar', function ($view) {
            $user = Auth::user();
            $pendingBookingsCount = 0;

            if ($user && $user->role === 'affiliate') {
                $carIds = Car::where('user_id', $user->id)->pluck('id')->toArray();
                $propertyIds = Property::where('user_id', $user->id)->pluck('id')->toArray();

                $pendingBookingsCount = Booking::where('status', 'pending')
                    ->where(function($q) use ($carIds, $propertyIds) {
                        $q->where(function($sq) use ($carIds) {
                            $sq->where('bookable_type', 'App\Models\Car')
                               ->whereIn('bookable_id', $carIds);
                        })->orWhere(function($sq) use ($propertyIds) {
                            $sq->where('bookable_type', 'App\Models\Property')
                               ->whereIn('bookable_id', $propertyIds);
                        });
                    })->count();
            }

            $view->with('pendingBookingsCount', $pendingBookingsCount);
        });

        // Share pending bookings count with the customer sidebar
        View::composer('components.customer.sidebar', function ($view) {
            $user = Auth::user();
            $pendingBookingsCount = 0;

            if ($user && ($user->role === 'customer' || $user->role === 'user')) {
                $pendingBookingsCount = Booking::where('user_id', $user->id)
                    ->where('status', 'pending')
                    ->count();
            }

            $view->with('pendingBookingsCount', $pendingBookingsCount);
        });
    }
}
