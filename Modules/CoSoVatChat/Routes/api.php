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
    'prefix' => 'dien-tich',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{year}', 'DienTichController@index')->name('dien-tich.list');
    Route::post('/{year}', 'DienTichController@store')->name('dien-tich.create');
});
