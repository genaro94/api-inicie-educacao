<?php

namespace App\Http\Interfaces\Post;

interface IUserPostListing
{
    function execute(int $id): array;
}
