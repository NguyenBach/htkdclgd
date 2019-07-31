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

Route::group([
    'prefix' => 'nhom-nganh',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/', 'NhomNganhController@list')->name('nhom-nganh.list');
    Route::get('/{id}', 'NhomNganhController@show')->name('nhom-nganh.show');
    Route::post('/', 'NhomNganhController@store')->name('nhom-nganh.create');
    Route::put('/{model}', 'NhomNganhController@update')->name('nhom-nganh.update');
    Route::delete('/{model}', 'NhomNganhController@destroy')->name('nhom-nganh.delete');
});

Route::group([
    'prefix' => 'sach-thu-vien',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{year}', 'SachThuVienController@list')->name('sach-thu-vien.list');
    Route::post('/{year}/{nhomNganh}', 'SachThuVienController@create')->name('sach-thu-vien.create');
});

