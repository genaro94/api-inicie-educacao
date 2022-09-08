<?php

namespace App\Application\Comment;

use App\Http\Interfaces\Comment\ICommentCreation;
use App\Facades\ExternalApiFacade;
use Illuminate\Http\Request;
use Exception;

class CommentCreation implements ICommentCreation
{
    function execute(Request $request): array
    {
        $response = ExternalApiFacade::withToken($request->bearerToken())
        ->post('/comments', [
            'post_id' => $request->post_id,
            'name'    => $request->name,
            'email'   => $request->email,
            'body'    => $request->body,
        ])->json();

        if (isset($response['message'])) throw new Exception($response['message']);
        if (isset($response[0]['field'])) throw new Exception($response[0]['field'].' '.$response[0]['message']);

        return $response;
    }
}
