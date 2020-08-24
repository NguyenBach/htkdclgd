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
    'prefix' => 'danh-muc-minh-chung',
    'middleware' => 'jwt.auth'
], function () {
    Route::post('/', 'DanhMucMinhChungController@store')->name('danh-muc-minh-chung.create');
    Route::get('/', 'DanhMucMinhChungController@index')->name('danh-muc-minh-chung.get');
});

Route::group([
    'prefix' => 'bao-cao-tu-danh-gia',
    'middleware' => 'jwt.auth'
], function () {
    Route::post('/', 'BaoCaoTuDanhGiaController@store')->name('bao-cao-tu-danh-gia.create');
    Route::get('/', 'BaoCaoTuDanhGiaController@index')->name('bao-cao-tu-danh-gia.get');
    Route::post('/{baoCao}/comment/', 'BaoCaoTuDanhGiaController@comment')->name('bao-cao-tu-danh-gia.comment');
});
