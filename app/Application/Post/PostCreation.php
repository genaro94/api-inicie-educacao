<?php

namespace App\Application\Post;

use App\Http\Interfaces\Post\IPostCreation;
use App\Facades\ExternalApiFacade;
use Illuminate\Http\Request;

class PostCreation implements IPostCreation
{
    function execute(Request $request): array
    {
        return ExternalApiFacade::withToken($request->bearerToken())
        ->post('/posts', [
            'user_id' => $request->user_id,
            'title'   => $request->title,
            'body'    => $request->body,
        ])->json();
    }
}
