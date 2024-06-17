<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Modules;
use App\Models\Permissions;

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
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }
        // Compartiendo variables con la vista navigation-menu
        View::composer('navigation-menu', function ($view) {
            $modules = Modules::all()->sortBy('order_index');
            $permissions = Permissions::all();

            $view->with(compact('modules', 'permissions'));
        });
    }
}
