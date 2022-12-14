<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\User\IUserCreation;
use App\Http\Interfaces\User\IUserListing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private IUserCreation $userCreation, private IUserListing $userListingFilterById) {}

    public function store(Request $request): JsonResponse
    {
        $response = $this->userCreation->execute($request);

        return response()->json($response, $response['code']);
    }

    public function index(Request $request, string $userId = ''): JsonResponse
    {
        $response = $this->userListingFilterById->execute($request, $userId);

        return response()->json($response, $response['code']);
    }
}
