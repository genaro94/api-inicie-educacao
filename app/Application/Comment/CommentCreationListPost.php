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
        ->post('/todos', [
            "user_id" => $request->user_id,
            "title"   => $request->title,
            "due_on"  => $request->due_on,
            "status"  => $request->status
        ])->json();
    }
}
