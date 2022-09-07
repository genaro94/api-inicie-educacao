<?php

namespace App\Http\Interfaces;

use Illuminate\Http\Request;

interface IUserCreation
{
    function execute(Request $request): array;
}