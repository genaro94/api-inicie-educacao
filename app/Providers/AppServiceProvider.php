<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        //
    }

    public function boot()
    {
        Schema::defaultStringLength(191);

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

        $this->app->bind(
            'App\Http\Interfaces\Comment\ICommentCreationListPost',
            'App\Application\Comment\CommentCreationListPost',
        );

        $this->app->bind(
            'App\Http\Interfaces\Comment\ICommentDestroy',
            'App\Application\Comment\CommentDestroy',
        );

        $this->app->bind(
            'App\Http\Interfaces\Post\IUserPostListing',
            'App\Application\Post\UserPostListing',
        );
    }
}
