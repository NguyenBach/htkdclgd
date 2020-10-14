<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('thongtinchung')->group(function() {
    Route::get('/', function (){
        $number = new NumberFormatter('vi_VI',  NumberFormatter::CURRENCY);
        dd($number->formatCurrency(10000000,'VND'));
    });
});
