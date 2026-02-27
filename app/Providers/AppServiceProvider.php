<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\User;

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
        // Share pending affiliate count with the admin sidebar
        View::composer('components.admin.sidebar', function ($view) {
            $pendingAffiliatesCount = User::where('role', 'affiliate')
                ->where('status', 'pending')
                ->count();

            $view->with('pendingAffiliatesCount', $pendingAffiliatesCount);
        });
    }
}
