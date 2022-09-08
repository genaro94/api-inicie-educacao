<?php

namespace App\Http\Interfaces\User;

use Illuminate\Http\Request;

interface IUserListing
{
    function execute(Request $request): array;
}
