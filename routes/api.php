<?php

Route::group(['prefix' => 'users'], function () {
    Route::post('/', 'UserController@store');
    Route::get('/{page?}', 'UserController@index');
});

Route::group(['prefix' => 'posts'], function () {
    Route::resource('/', 'PostController');
});
