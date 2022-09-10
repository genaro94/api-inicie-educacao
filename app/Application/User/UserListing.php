<?php

namespace App\Application\User;

use App\Http\Interfaces\User\IUserListing;
use App\Facades\ExternalApiFacade;
use Illuminate\Http\Request;
use Exception;

class UserListing implements IUserListing
{
    function execute(Request $request): array
    {
        return ExternalApiFacade::get('/users' .'/'.$request->id.'?page='. $request->page)->json();
    }
}
