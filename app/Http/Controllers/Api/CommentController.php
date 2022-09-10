<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Comment\ICommentCreation;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class CommentController extends Controller
{
    public function __construct(private ICommentCreation $commentCreation) {}

    public function store(Request $request): JsonResponse
    {
        try
        {
            $comment = $this->commentCreation->execute($request);

            return response()->json([
                'message' => 'Comment created successfully!',
                'comment' => $comment
            ], Response::HTTP_CREATED);
        }
        catch (Exception $exception)
        {
            return response()->json(['message' => $exception->getMessage() ], Response::HTTP_UNAUTHORIZED);
        }
    }
}
