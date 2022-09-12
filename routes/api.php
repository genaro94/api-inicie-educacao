<?php

Route::group(['prefix' => 'users'], function () {
    Route::post('/', 'UserController@store');
    Route::get('/{id?}', 'UserController@index');
});

Route::group(['prefix' => 'posts'], function () {
    Route::resource('/', 'PostController');
});

Route::group(['prefix' => 'comments'], function () {
    Route::resource('/', 'CommentController');
    Route::post('/store/list/posts', 'CommentController@storeListPosts');
});
