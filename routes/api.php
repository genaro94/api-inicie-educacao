<?php

Route::group(['prefix' => 'users', 'namespace' => 'Api\\'], function () {
    Route::post('/', 'UserController@store');
    Route::get('/{page?}', 'UserController@index');
});
