<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;

class GlobalVariableShare extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // View::share('bg_class', 'active');
    }
}
