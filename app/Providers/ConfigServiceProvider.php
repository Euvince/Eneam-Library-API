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
        $configuration = \App\Models\Configuration::first();
        config(['app.configuration' => $configuration]);
        // Pour faire une récupération : Config::get('app.configuration.price')
    }
}
