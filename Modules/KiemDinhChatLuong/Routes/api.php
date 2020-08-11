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
    Route::get('/', 'KiemDinhChatLuongController@index')->name('kiem-dinh.list');
    Route::post('/', 'KiemDinhChatLuongController@store')->name('kiem-dinh.create');
    Route::put('/{model}', 'KiemDinhChatLuongController@update')->name('kiem-dinh.update');
    Route::delete('/{model}', 'KiemDinhChatLuongController@destroy')->name('kiem-dinh.delete');
});
Route::group([
    'prefix' => 'doi-tuong-kiem-dinh',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/', 'DoiTuongKiemDinhController@list')->name('doi-tuong-kiem-dinh.list');
    Route::post('/', 'DoiTuongKiemDinhController@store')->name('doi-tuong-kiem-dinh.create');
    Route::put('/{model}', 'DoiTuongKiemDinhController@update')->name('doi-tuong-kiem-dinh.update');
    Route::delete('/{model}', 'DoiTuongKiemDinhController@delete')->name('doi-tuong-kiem-dinh.delete');
});

Route::group([
    'prefix' => 'tieu-chuan-kiem-dinh',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/', 'BoTieuChuanController@index')->name('tieu-chuan-kiem-dinh.list');
    Route::post('/', 'BoTieuChuanController@store')->name('tieu-chuan-kiem-dinh.create');
//    Route::put('/{model}', 'BoTieuChuanController@update')->name('tieu-chuan-kiem-dinh.update');
//    Route::delete('/{model}', 'BoTieuChuanController@delete')->name('tieu-chuan-kiem-dinh.delete');
});

Route::group([
    'prefix' => 'to-chuc-kiem-dinh',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/', 'ToChucKiemDinhController@index')->name('to-chuc-kiem-dinh.list');
    Route::post('/', 'ToChucKiemDinhController@store')->name('to-chuc-kiem-dinh.create');
//    Route::put('/{model}', 'BoTieuChuanController@update')->name('to-chuc-kiem-dinh.update');
//    Route::delete('/{model}', 'BoTieuChuanController@delete')->name('to-chuc-kiem-dinh.delete');
});

