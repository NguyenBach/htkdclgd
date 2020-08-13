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
