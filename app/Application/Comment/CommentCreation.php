<?php

namespace App\Application\Comment;

use App\Http\Interfaces\Comment\ICommentCreation;
use App\Facades\ExternalApiFacade;
use Illuminate\Http\Request;

class CommentCreation implements ICommentCreation
{
    function execute(Request $request, int $postId): array
    {
        return ExternalApiFacade::withToken($request->bearerToken())
        ->post('/posts'.'/'. $postId .'/comments', [
            'name'    => $request->name,
            'email'   => $request->email,
            'body'    => $request->body,
        ])->json();
    }
}
