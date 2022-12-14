<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'users'], function () {
    Route::post('/', 'UserController@store');
    Route::get('/{id?}', 'UserController@index');
    Route::post('/{id}/posts', 'PostController@store');
    Route::get('/{id}/posts', 'PostController@index');
});

Route::group(['prefix' => 'posts'], function () {
    Route::post('/{id}/comments', 'CommentController@store');
});

Route::group(['prefix' => 'comments'], function () {
    Route::post('/store/list/posts', 'CommentController@storeListPosts');
    Route::delete('/{id}', 'CommentController@destroy');
});
