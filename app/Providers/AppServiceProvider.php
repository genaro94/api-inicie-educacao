<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        //
    }

    public function boot()
    {
        $this->app->bind(
            'App\Http\Interfaces\IUserCreation',
            'App\Application\UserCreation',
        );

        $this->app->bind(
            'App\Http\Interfaces\IUserListing',
            'App\Application\UserListing',
        );
    }
}
