<?php

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Route;

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
    'prefix' => 'so-luong-nckh',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{year}', 'SoLuongNCKHController@index')->name('so-luong-nckh.list');
    Route::post('/{year}', 'SoLuongNCKHController@store')->name('so-luong-nckh.create');
});

Route::group([
    'prefix' => 'doanh-thu-nckh',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{year}', 'DoanhThuNCKHController@index')->name('doanh-thu-nckh.list');
    Route::post('/{year}', 'DoanhThuNCKHController@store')->name('doanh-thu-nckh.create');
});

Route::group([
    'prefix' => 'can-bo-nckh',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{year}', 'CanBoNCKHController@index')->name('can-bo-nckh.list');
    Route::post('/{year}', 'CanBoNCKHController@store')->name('can-bo-nckh.create');
});