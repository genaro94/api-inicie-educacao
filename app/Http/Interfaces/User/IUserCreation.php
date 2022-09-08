<?php

namespace App\Http\Interfaces\User;

use Illuminate\Http\Request;

interface IUserCreation
{
    function execute(Request $request): array;
}
