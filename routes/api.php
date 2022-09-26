<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'users'], function () {
    Route::post('/', 'UserController@store');
    Route::get('/{id?}', 'UserController@index');
    Route::post('/{id}/posts', 'PostController@store');
});


Route::group(['prefix' => 'comments'], function () {
    Route::resource('/', 'CommentController');
    Route::delete('/{id}', 'CommentController@destroy');
    Route::post('/store/list/posts', 'CommentController@storeListPosts');
});
