<?php

namespace App\Application\Comment;

use App\Http\Interfaces\Comment\ICommentCreationListPost;
use App\Facades\ExternalApiFacade;
use Illuminate\Http\Request;

class CommentCreationListPost implements ICommentCreationListPost
{
    function execute(Request $request): array
    {
        return ExternalApiFacade::withToken($request->bearerToken())
        ->post('/comments', [
            "post_id" => $request->post_id,
            "name"    => $request->name,
            "email"   => $request->email,
            "body"    => $request->body
        ])->json();
    }
}
