<?php

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
    'prefix' => 'lecturer',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{year}', 'LecturerController@index')->name('lecturer.list');
    Route::post('/{year}', 'LecturerController@store')->name('lecturer.create');
});