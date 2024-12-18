<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Directive untuk pengecekan pengguna pengelola (admin/manager)
        Blade::if('pengelola', function () {
            return Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'manager');
        });

        // Directive untuk pengecekan pengguna biasa (user biasa)
        Blade::if('viewer', function () {
            return Auth::check() && Auth::user()->role == 'user';
        });
    }
}
