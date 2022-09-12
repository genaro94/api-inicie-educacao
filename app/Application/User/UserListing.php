<?php

namespace App\Application\User;

use App\Http\Interfaces\User\IUserListing;
use App\Facades\ExternalApiFacade;
use Illuminate\Http\Request;
use Exception;

class UserListing implements IUserListing
{
    function execute(Request $request, string $userId): array
    {
        return ExternalApiFacade::get('/users' .'/'.$userId. '?page='. $request->page)->json();
    }
}
