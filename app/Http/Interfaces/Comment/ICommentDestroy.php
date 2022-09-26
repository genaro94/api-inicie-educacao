<?php

namespace App\Http\Interfaces\Comment;

use Illuminate\Http\Request;

interface ICommentDestroy
{
    function execute(Request $request, int $id): array;
}
