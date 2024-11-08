<?php

namespace App\Providers;

use App\Http\Controllers\FretusFolks;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('FretusFolks', function ($app) {
            return new FretusFolks;
        });
    }

    public function boot()
    {
        // Other bootstrapping if needed
    }
}
