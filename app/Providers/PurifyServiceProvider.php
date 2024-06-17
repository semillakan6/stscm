<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use HTMLPurifier;
use HTMLPurifier_Config;

class PurifyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton(HTMLPurifier::class, function () {
            $config = HTMLPurifier_Config::createDefault();

            return new HTMLPurifier($config);
        }); 
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        view()->share('purifier', app(HTMLPurifier::class));
    }
}
