<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('/login', 'AuthController@login')->name('auth.login');
    Route::post('/logout', 'AuthController@logout')
        ->name('auth.logout');
});

Route::group([
    'prefix' => 'permission',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/list', 'PermissionController@list')->name('permission.list');
});

Route::group([
    'prefix' => 'role',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/list', 'RoleController@list')->name('role.list');
});


Route::group([
    'prefix' => 'user',
    'middleware' => 'jwt.auth',
], function () {
    Route::get('/me', 'UserController@me')
        ->name('user.me');
    Route::get('/profile/{id}', 'UserController@profile')
        ->name('user.profile');
    Route::post('/create', 'UserController@create')
        ->name('user.create');
    Route::post('/update/{user}', 'UserController@update')
        ->name('user.update');
    Route::get('/list', 'UserController@list')
        ->name('user.list');
    Route::post('/delete/{user}', 'UserController@delete')
        ->name('user.delete');
});
