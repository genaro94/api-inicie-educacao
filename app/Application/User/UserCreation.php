<?php

namespace App\Application\User;

use App\Http\Interfaces\User\IUserCreation;
use App\Facades\ExternalApiFacade;
use Illuminate\Http\Request;

class UserCreation implements IUserCreation
{
    function execute(Request $request): array
    {
        $response = ExternalApiFacade::withToken($request->bearerToken())
        ->post('/users', [
            'name'   => $request->name,
            'gender' => $request->gender,
            'email'  => $request->email,
            'status' => $request->status
        ])->json();

        return $response;
    }
}
