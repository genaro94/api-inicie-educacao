<?php

Route::group(['prefix' => 'users', 'namespace' => 'Api\\'], function () {
    Route::resource('/', 'UserController');
});
