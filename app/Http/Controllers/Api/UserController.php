<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\User\IUserCreation;
use App\Http\Interfaces\User\IUserListing;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class UserController extends Controller
{
    public function __construct(private IUserCreation $userCreation, private IUserListing $userListingFilterById) {}

    public function store(Request $request): JsonResponse
    {
        try
        {
            $user = $this->userCreation->execute($request);

            return response()->json([
                'message' => 'User created successfully!',
                'user'    => $user
            ], Response::HTTP_CREATED);
        }
        catch (Exception $exception)
        {
            return response()->json(['message' => $exception->getMessage() ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function index(Request $request): JsonResponse
    {
        $list = $this->userListingFilterById->execute($request);

        return response()->json(['data' => $list], Response::HTTP_OK);
    }
}
