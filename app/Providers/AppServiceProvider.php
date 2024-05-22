<?php

namespace App\Providers;

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

     //Establecer zona horaria y devuelve hora correcto 
    public function boot(): void
    {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
    }
}
