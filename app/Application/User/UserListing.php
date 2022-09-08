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
        $response = ExternalApiFacade::withToken($request->bearerToken())
        ->get('/users' .'/'.$request->id .'?page='.$request->page)
        ->json();

        return $response;
    }
}
