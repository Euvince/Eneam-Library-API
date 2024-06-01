<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $config = \App\Models\Configuration::latest();
        config(['app.configuration' => $config]);
        // Pour faire une récupération : Config::get('app.configuration.price')
    }
}
