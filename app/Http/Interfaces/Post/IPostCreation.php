<?php

namespace App\Http\Interfaces\Post;

use Illuminate\Http\Request;

interface IPostCreation
{
    function execute(Request $request): array;
}
