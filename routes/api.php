<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'users'], function () {
    Route::post('/', 'UserController@store');
    Route::get('/{id?}', 'UserController@index');
    Route::post('/{id}/posts', 'PostController@store');
});

Route::group(['prefix' => 'posts'], function () {
    Route::post('/{id}/comments', 'CommentController@store');
});

Route::group(['prefix' => 'comments'], function () {
    Route::delete('/{id}', 'CommentController@destroy');
    Route::post('/store/list/posts', 'CommentController@storeListPosts');
});
