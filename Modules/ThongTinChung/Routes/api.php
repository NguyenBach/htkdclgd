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
    Route::get('/training-type/list', 'UniversityController@getTrainingType')->name('university.getTrainingType');
});

Route::group([
    'prefix' => 'department',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/list', 'DepartmentController@list')->name('department.list');
    Route::post('/create', 'DepartmentController@create')->name('university.create');
    Route::post('/update/{department}', 'DepartmentController@update')->name('university.update');
    Route::post('/delete/{department}', 'DepartmentController@delete')->name('university.delete');
});

Route::group([
    'prefix' => 'key-officer',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/list', 'KeyOfficerController@list')->name('key-officer.list');
    Route::post('/create', 'KeyOfficerController@create')->name('key-officer.create');
    Route::post('/update/{keyOfficer}', 'KeyOfficerController@update')->name('key-officer.update');
    Route::post('/delete/{keyOfficer}', 'KeyOfficerController@delete')->name('key-officer.delete');
});

Route::group([
    'prefix' => 'education-type',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/list', 'EducationTypeController@list')->name('education-type.list');
    Route::post('/create', 'EducationTypeController@create')->name('education-type.create');
    Route::post('/update/{educationType}', 'EducationTypeController@update')->name('education-type.update');
    Route::post('/delete/{educationType}', 'EducationTypeController@delete')->name('education-type.delete');
});

Route::group([
    'prefix' => 'faculty',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/list', 'FacultyController@list')->name('faculty.list');
    Route::post('/create', 'FacultyController@create')->name('faculty.create');
    Route::post('/update/{faculty}', 'FacultyController@update')->name('faculty.update');
    Route::post('/delete/{faculty}', 'FacultyController@delete')->name('faculty.delete');
});

Route::group([
    'prefix' => 'branch',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/list', 'BranchController@index')->name('faculty.list');
    Route::post('/create', 'BranchController@store')->name('faculty.create');
    Route::post('/update/{faculty}', 'BranchController@update')->name('faculty.update');
    Route::post('/delete/{faculty}', 'BranchController@delete')->name('faculty.delete');
});