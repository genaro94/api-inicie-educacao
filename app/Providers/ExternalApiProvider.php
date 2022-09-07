<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;

class ExternalApiProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind('api-inicie-educacao', function() {
            return Http::withOptions([
                'verify'   => false,
                'base_uri' => 'https://gorest.co.in/public/v2/'
            ]);
        });
    }
}
