<?php

namespace App\Application\Post;

use App\Http\Interfaces\Post\IPostCreation;
use App\Facades\ExternalApiFacade;
use Illuminate\Http\Request;
use Exception;

class PostCreation implements IPostCreation
{
    function execute(Request $request): array
    {
        $response = ExternalApiFacade::withToken($request->bearerToken())
        ->post('/posts', [
            'user_id' => $request->user_id,
            'title'   => $request->title,
            'body'    => $request->body,
        ])->json();

        if (isset($response['message'])) throw new Exception($response['message']);
        if (isset($response[0]['field'])) throw new Exception($response[0]['field'].' '.$response[0]['message']);

        return $response;
    }
}
