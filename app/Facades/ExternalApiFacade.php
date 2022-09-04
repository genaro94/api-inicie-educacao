<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ExternalApiFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'api-inicie-educacao';
    }
}
