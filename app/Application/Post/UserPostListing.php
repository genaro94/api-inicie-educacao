<?php

namespace App\Application\Post;

use App\Http\Interfaces\Post\IUserPostListing;
use App\Facades\ExternalApiFacade;

class UserPostListing implements IUserPostListing
{
    function execute(int $id): array
    {
        return ExternalApiFacade::get('/users'. '/'. $id .'/posts')->json();
    }
}
