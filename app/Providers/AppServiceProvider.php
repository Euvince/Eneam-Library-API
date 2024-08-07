<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Carbon\Carbon::setLocale('fr');
        /* \Carbon\Carbon::setLocale(LC_TIME, 'fr_FR.UTF-8'); */

        Paginator::useBootstrapFive();
    }
}
