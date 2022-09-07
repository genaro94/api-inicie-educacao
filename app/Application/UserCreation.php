<?php

namespace App\Application;

use App\Http\Interfaces\IUserCreation;
use App\Facades\ExternalApiFacade;
use Illuminate\Http\Request;
use Exception;

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

        if (isset($response['message'])) throw new Exception($response['message']);
        if (isset($response[0]['field'])) throw new Exception($response[0]['field'].' '.$response[0]['message']);

        return $response;
    }
}
