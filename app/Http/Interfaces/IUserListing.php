<?php

namespace App\Http\Interfaces;

use Illuminate\Http\Request;

interface IUserListing
{
    function execute(Request $request): array;
}
