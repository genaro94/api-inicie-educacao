<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Post\IPostCreation;
use App\Http\Interfaces\Post\IUserPostListing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(private IPostCreation $postCreation,
                                private IUserPostListing $userPostListing) {}

    public function index(int $id): JsonResponse
    {
        $response = $this->userPostListing->execute($id);

        return response()->json($response, $response['code']);
    }

    public function store(Request $request, int $id): JsonResponse
    {
        $response = $this->postCreation->execute($request, $id);

        return response()->json($response, $response['code']);
    }

}
