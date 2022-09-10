<?php

namespace App\Http\Interfaces\Comment;

use Illuminate\Http\Request;

interface ICommentCreationListPost
{
    function execute(Request $request): array;
}
