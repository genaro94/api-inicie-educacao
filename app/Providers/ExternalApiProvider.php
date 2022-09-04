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
            ])
            ->withHeaders([
                'Authorization' => 'Bearer 7ba03f2c0a0909bd7c37efaadaa54777c2d0ff1d190878475c8fa953c3399609'
            ]);
        });
    }
}
