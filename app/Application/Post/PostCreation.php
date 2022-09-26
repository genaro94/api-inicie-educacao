<?php

namespace App\Application\Post;

use App\Http\Interfaces\Post\IPostCreation;
use App\Facades\ExternalApiFacade;
use Illuminate\Http\Request;

class PostCreation implements IPostCreation
{
    function execute(Request $request, int $id): array
    {
        return ExternalApiFacade::withToken($request->bearerToken())
        ->post('/users'. '/'. $id .'/posts', [
            'title'   => $request->title,
            'body'    => $request->body,
        ])->json();
    }
}
