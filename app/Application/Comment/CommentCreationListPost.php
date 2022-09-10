<?php

namespace App\Application\Comment;

use App\Http\Interfaces\Comment\ICommentCreationListPost;
use App\Facades\ExternalApiFacade;
use Illuminate\Http\Request;
use Exception;

class CommentCreationListPost implements ICommentCreationListPost
{
    function execute(Request $request): array
    {
        $response = ExternalApiFacade::withToken($request->bearerToken())
        ->post('/todos', [
            "user_id" => $request->user_id,
            "title"   => $request->title,
            "due_on"  => $request->due_on,
            "status"  => $request->status
        ])->json();

        if (isset($response['message'])) throw new Exception($response['message']);
        if (isset($response[0]['field'])) throw new Exception($response[0]['field'].' '.$response[0]['message']);

        return $response;
    }
}
