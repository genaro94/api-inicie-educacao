<?php

namespace App\Http\Interfaces\Comment;

use Illuminate\Http\Request;

interface ICommentCreation
{
    function execute(Request $request): array;
}
