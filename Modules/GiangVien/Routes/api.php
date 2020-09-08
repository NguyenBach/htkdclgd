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
    Route::get('/{year}', 'LecturerController@index')->name('lecturer.index');
    Route::get('list/{year}', 'LecturerController@list')->name('lecturer.list');
    Route::post('/{year}', 'LecturerController@store')->name('lecturer.create');
});

Route::group([
    'prefix' => 'officer',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{year}', 'OfficerController@show')->name('officer.show');
    Route::get('list/{year}', 'OfficerController@list')->name('officer.list');
    Route::post('/{year}', 'OfficerController@store')->name('officer.create');
});

Route::group([
    'prefix' => 'officer-by-gender',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{year}', 'OfficerByGenderController@show')->name('officer-by-gender.show');
    Route::get('list/{year}', 'OfficerByGenderController@list')->name('officer-by-gender.list');
    Route::post('/{year}', 'OfficerByGenderController@store')->name('officer-by-gender.create');
});

Route::group([
    'prefix' => 'lecturer-by-degree',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{year}', 'LecturerByDegreeController@index')->name('lecturer-by-degree.index');
    Route::get('list/{year}', 'LecturerByDegreeController@list')->name('lecturer-by-degree.list');
    Route::post('/{year}', 'LecturerByDegreeController@store')->name('lecturer-by-degree.create');
});

Route::group([
    'prefix' => 'lecturer-by-age',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{year}', 'LecturerByAgeController@index')->name('lecturer-by-age.list');
    Route::get('list/{year}', 'LecturerByAgeController@list')->name('lecturer-by-age.list5');
    Route::post('/{year}', 'LecturerByAgeController@store')->name('lecturer-by-age.create');
});

Route::group([
    'prefix' => 'lecturer-by-fl',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/{year}', 'LecturerByFlController@index')->name('lecturer-by-fl.index');
    Route::get('list/{year}', 'LecturerByFlController@list')->name('lecturer-by-fl.list');
    Route::post('/{year}', 'LecturerByFlController@store')->name('lecturer-by-fl.create');
});
