<?php

namespace ConfrariaWeb\Address\Providers;

use Illuminate\Support\ServiceProvider;

class AddressServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../databases/Migrations');
        $this->publishes([__DIR__ . '/../../config/cw_address.php' => config_path('cw_address.php')], 'config');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }
}
