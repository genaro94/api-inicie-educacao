<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Comment\ICommentCreation;
use App\Http\Interfaces\Comment\ICommentCreationListPost;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct(private ICommentCreation $commentCreation,
                                private ICommentCreationListPost $commentCreationListPosts) {}

    public function store(Request $request): JsonResponse
    {
        $response = $this->commentCreation->execute($request);

        return response()->json($response, $response['code']);
    }

    public function storeListPosts(Request $request): JsonResponse
    {

        $response = $this->commentCreationListPosts->execute($request);

        return response()->json($response, $response['code']);
    }
}
