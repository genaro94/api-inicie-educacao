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
        return ExternalApiFacade::withToken($request->bearerToken())
        ->post('/comments', [
            'post_id' => $request->post_id,
            'name'    => $request->name,
            'email'   => $request->email,
            'body'    => $request->body,
        ])->json();
    }
}
