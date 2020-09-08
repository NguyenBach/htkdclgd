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
    Route::get('/{year}', 'SoLuongNCKHController@index')->name('so-luong-nckh.index');
    Route::get('list/{year}', 'SoLuongNCKHController@list')->name('so-luong-nckh.list');
    Route::post('/{year}', 'SoLuongNCKHController@store')->name('so-luong-nckh.create');
});

Route::group([
    'prefix' => 'doanh-thu-nckh',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{year}', 'DoanhThuNCKHController@index')->name('doanh-thu-nckh.index');
    Route::get('list/{year}', 'DoanhThuNCKHController@list')->name('doanh-thu-nckh.list');
    Route::post('/{year}', 'DoanhThuNCKHController@store')->name('doanh-thu-nckh.create');
});

Route::group([
    'prefix' => 'can-bo-nckh',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{year}', 'CanBoNCKHController@index')->name('can-bo-nckh.index');
    Route::get('list/{year}', 'CanBoNCKHController@list')->name('can-bo-nckh.list');
    Route::post('/{year}', 'CanBoNCKHController@store')->name('can-bo-nckh.create');
});

Route::group([
    'prefix' => 'so-luong-sach',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{year}', 'SoLuongSachController@index')->name('so-luong-sach.index');
    Route::get('list/{year}', 'SoLuongSachController@list')->name('so-luong-sach.list');
    Route::post('/{year}', 'SoLuongSachController@store')->name('so-luong-sach.create');
});

Route::group([
    'prefix' => 'tap-chi-duoc-dang',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{year}', 'TapChiDuocDangController@index')->name('tap-chi-duoc-dang.index');
    Route::get('list/{year}', 'TapChiDuocDangController@list')->name('tap-chi-duoc-dang.list');
    Route::post('/{year}', 'TapChiDuocDangController@store')->name('tap-chi-duoc-dang.create');
});

Route::group([
    'prefix' => 'can-bo-tap-chi',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{year}', 'CanBoTapChiController@index')->name('can-bo-tap-chi.index');
    Route::get('list/{year}', 'CanBoTapChiController@list')->name('can-bo-tap-chi.list');
    Route::post('/{year}', 'CanBoTapChiController@store')->name('can-bo-tap-chi.create');
});

Route::group([
    'prefix' => 'bao-cao-hoi-thao',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{year}', 'BaoCaoHoiThaoController@index')->name('bao-cao-hoi-thao.index');
    Route::get('list/{year}', 'BaoCaoHoiThaoController@list')->name('bao-cao-hoi-thao.list');
    Route::post('/{year}', 'BaoCaoHoiThaoController@store')->name('bao-cao-hoi-thao.create');
});

Route::group([
    'prefix' => 'can-bo-hoi-thao',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{year}', 'CanBoHoiThaoController@index')->name('can-bo-hoi-thao.index');
    Route::get('list/{year}', 'CanBoHoiThaoController@list')->name('can-bo-hoi-thao.list');
    Route::post('/{year}', 'CanBoHoiThaoController@store')->name('can-bo-hoi-thao.create');
});

Route::group([
    'prefix' => 'can-bo-sach',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{year}', 'CanBoSachController@index')->name('can-bo-sach.index');
    Route::get('list/{year}', 'CanBoSachController@list')->name('can-bo-sach.list');
    Route::post('/{year}', 'CanBoSachController@store')->name('can-bo-sach.create');
});

Route::group([
    'prefix' => 'bang-sang-che',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{year}', 'BangSangCheController@index')->name('bang-sang-che.index');
    Route::get('list/{year}', 'BangSangCheController@list')->name('bang-sang-che.list');
    Route::post('/{year}', 'BangSangCheController@store')->name('bang-sang-che.create');
});

Route::group([
    'prefix' => 'sv-nckh',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{year}', 'SvNCKHController@index')->name('sv-nckh.index');
    Route::get('list/{year}', 'SvNCKHController@list')->name('sv-nckh.list');
    Route::post('/{year}', 'SvNCKHController@store')->name('sv-nckh.create');
});

Route::group([
    'prefix' => 'thanh-tich-nckh',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{year}', 'ThanhTichController@index')->name('thanh-tich-nckh.index');
    Route::get('list/{year}', 'ThanhTichController@list')->name('thanh-tich-nckh.list');
    Route::post('/{year}', 'ThanhTichController@store')->name('thanh-tich-nckh.create');
});



