<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        // App Environment.
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }

        // App Db Schema.
        Schema::defaultStringLength(191);
    }
}
