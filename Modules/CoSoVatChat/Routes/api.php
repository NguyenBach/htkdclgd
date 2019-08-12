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

Route::group([
    'prefix' => 'trang-thiet-bi',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/', 'TrangThietBiController@list')->name('trang-thiet-bi.list');
    Route::get('/{trangThietBi}', 'TrangThietBiController@show')->name('trang-thiet-bi.list');
    Route::post('/', 'TrangThietBiController@create')->name('trang-thiet-bi.create');
    Route::put('/{trangThietBi}', 'TrangThietBiController@update')->name('trang-thiet-bi.update');
    Route::delete('/{trangThietBi}', 'TrangThietBiController@delete')->name('trang-thiet-bi.delete');
});

Route::group([
    'prefix' => 'thiet-bi',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/', 'ThietBiController@index')->name('thiet-bi.list');
    Route::get('/{thietBi}', 'ThietBiController@show')->name('thiet-bi.list');
    Route::post('/', 'ThietBiController@store')->name('thiet-bi.create');
    Route::put('/{thietBi}', 'ThietBiController@update')->name('thiet-bi.update');
    Route::delete('/{thietBi}', 'ThietBiController@destroy')->name('thiet-bi.delete');
});
