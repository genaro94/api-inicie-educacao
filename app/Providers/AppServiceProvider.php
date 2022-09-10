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
            'App\Http\Interfaces\User\IUserCreation',
            'App\Application\User\UserCreation',
        );

        $this->app->bind(
            'App\Http\Interfaces\User\IUserListing',
            'App\Application\User\UserListing',
        );

        $this->app->bind(
            'App\Http\Interfaces\Post\IPostCreation',
            'App\Application\Post\PostCreation',
        );

        $this->app->bind(
            'App\Http\Interfaces\Comment\ICommentCreation',
            'App\Application\Comment\CommentCreation',
        );
    }
}
