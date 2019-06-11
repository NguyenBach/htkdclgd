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
    'prefix' => 'university',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/list', 'UniversityController@list')->name('university.list');
    Route::get('/{model}', 'UniversityController@view')->name('university.view');
    Route::post('/create', 'UniversityController@create')->name('university.create');
    Route::post('/update/{model}', 'UniversityController@update')->name('university.update');
});

Route::group([
    'prefix' => 'department',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/list', 'DepartmentController@list')->name('department.list');
//    Route::get('/{model}', 'DepartmentController@view')->name('university.view');
//    Route::post('/create', 'DepartmentController@create')->name('university.create');
});