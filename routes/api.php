<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');

Route::resource('servers', 'ServerController')->only([
    'index', 'show'
]);
