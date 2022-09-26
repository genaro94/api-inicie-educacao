<?php

namespace App\Application\Comment;

use App\Http\Interfaces\Comment\ICommentDestroy;
use App\Facades\ExternalApiFacade;
use Illuminate\Http\Request;

class CommentDestroy implements ICommentDestroy
{
    function execute(Request $request, int $id): array
    {
        return ExternalApiFacade::withToken($request->bearerToken())
        ->delete('/comments' .'/'. $id)->json();
    }
}
