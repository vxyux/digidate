<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        Blade::if('client', function () {
            $user = auth()->user();
            return $user && $user->is_admin == 0 && $user->is_enterprise == 0;
        });
        Blade::if('admin', function () {
            $user = auth()->user();
            return $user && $user->is_admin == 1;
        });
        Blade::if('enterpriser', function () {
            $user = auth()->user();
            return $user && $user->is_admin == 0 && $user->is_enterprise == 1;
        });
    }
}
