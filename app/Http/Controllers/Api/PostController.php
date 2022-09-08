<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Post\IPostCreation;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class PostController extends Controller
{
    public function __construct(private IPostCreation $postCreation) {}

    public function store(Request $request): JsonResponse
    {
        try
        {
            $post = $this->postCreation->execute($request);

            return response()->json([
                'message' => 'Post created successfully!',
                'post'    => $post
            ], Response::HTTP_CREATED);
        }
        catch (Exception $exception)
        {
            return response()->json(['message' => $exception->getMessage() ], Response::HTTP_UNAUTHORIZED);
        }
    }
}
