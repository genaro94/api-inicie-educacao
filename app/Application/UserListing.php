<?php

namespace App\Application;

use App\Http\Interfaces\IUserListing;
use App\Facades\ExternalApiFacade;
use Illuminate\Http\Request;
use Exception;

class UserListing implements IUserListing
{
    function execute(Request $request): array
    {
        $response = ExternalApiFacade::withToken($request->bearerToken())
        ->get('/users' .'/'.$request->id .'?page='.$request->page)
        ->json();

        return $response;
    }
}
