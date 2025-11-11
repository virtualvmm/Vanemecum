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
        // Directiva Blade para verificar si el usuario autenticado es Admin
        Blade::if('admin', function () {
            $user = auth()->user();
            return $user && method_exists($user, 'hasRole') && $user->hasRole('Admin');
        });
    }
}
