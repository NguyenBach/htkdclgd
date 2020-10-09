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
    'prefix' => 'kiem-dinh',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{year}', 'KiemDinhChatLuongController@index')->name('kiem-dinh.list');
    Route::post('/{year}', 'KiemDinhChatLuongController@store')->name('kiem-dinh.create');
    Route::put('/{model}', 'KiemDinhChatLuongController@update')->name('kiem-dinh.update');
    Route::delete('/{model}', 'KiemDinhChatLuongController@destroy')->name('kiem-dinh.delete');
});
