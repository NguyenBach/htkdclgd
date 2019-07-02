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
    'prefix' => 'sv-nhap-hoc',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{heHoc}/{year}', 'SVNhapHocController@index')->name('sv-nhap-hoc.list');
    Route::post('/{heHoc}/{year}', 'SVNhapHocController@store')->name('sv-nhap-hoc.create');
});