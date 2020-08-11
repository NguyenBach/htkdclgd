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
    'prefix' => 'lecturer',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{year}', 'LecturerController@index')->name('lecturer.list');
    Route::post('/{year}', 'LecturerController@store')->name('lecturer.create');
});

Route::group([
    'prefix' => 'officer',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{year}', 'OfficerController@show')->name('officer.list');
    Route::post('/{year}', 'OfficerController@store')->name('officer.create');
});

Route::group([
    'prefix' => 'officer-by-gender',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{year}', 'OfficerByGenderController@show')->name('officer-by-gender.list');
    Route::post('/{year}', 'OfficerByGenderController@store')->name('officer-by-gender.create');
});

Route::group([
    'prefix' => 'lecturer-by-degree',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{year}', 'LecturerByDegreeController@index')->name('lecturer-by-degree.list');
    Route::post('/{year}', 'LecturerByDegreeController@store')->name('lecturer-by-degree.create');
});

Route::group([
    'prefix' => 'lecturer-by-age',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{year}', 'LecturerByAgeController@index')->name('lecturer-by-age.list');
    Route::post('/{year}', 'LecturerByAgeController@store')->name('lecturer-by-age.create');
});

Route::group([
    'prefix' => 'lecturer-by-fl',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{year}', 'LecturerByFlController@index')->name('lecturer-by-fl.list');
    Route::post('/{year}', 'LecturerByFlController@store')->name('lecturer-by-fl.create');
});