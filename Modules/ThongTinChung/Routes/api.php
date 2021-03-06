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
    Route::get('/{model}/{year?}', 'UniversityController@view')->name('university.view');
    Route::post('/create', 'UniversityController@create')->name('university.create');
    Route::post('/update/{year}', 'UniversityController@updateUniversityData')->name('university.update');
    Route::delete('/delete/{model}', 'UniversityController@destroy')->name('university.destroy');
    Route::get('/training-type/list', 'UniversityController@getTrainingType')->name('university.getTrainingType');
});
Route::get('/training-type/list', 'UniversityController@getTrainingType')->name('university.getTrainingType');

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
    Route::get('/list/{year}', 'KeyOfficerController@list')->name('key-officer.list');
    Route::post('/create/{year}', 'KeyOfficerController@create')->name('key-officer.create');
    Route::post('/copy/{year}', 'KeyOfficerController@copy')->name('key-officer.copy');
    Route::post('/update/{keyOfficer}', 'KeyOfficerController@update')->name('key-officer.update');
    Route::post('/delete/{keyOfficer}', 'KeyOfficerController@delete')->name('key-officer.delete');
});

Route::group([
    'prefix' => 'education-type',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/list/{year}', 'EducationTypeController@list')->name('education-type.list');
    Route::post('/create/{year}', 'EducationTypeController@create')->name('education-type.create');
    Route::post('/update/{educationType}', 'EducationTypeController@update')->name('education-type.update');
    Route::post('/delete/{model}', 'EducationTypeController@delete')->name('education-type.delete');
});

Route::group([
    'prefix' => 'faculty',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/list/{year}', 'FacultyController@list')->name('faculty.list');
    Route::post('/create/{year}', 'FacultyController@create')->name('faculty.create');
    Route::post('/copy/{year}', 'FacultyController@copy')->name('faculty.copy');
    Route::post('/update/{faculty}', 'FacultyController@update')->name('faculty.update');
    Route::delete('/delete/{faculty}', 'FacultyController@delete')->name('faculty.delete');
});

Route::group([
    'prefix' => 'branch',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/list/{year}', 'BranchController@index')->name('faculty.list');
    Route::post('/create/{year}', 'BranchController@store')->name('faculty.create');
    Route::post('/copy/{year}', 'BranchController@copy')->name('faculty.copy');
    Route::post('/update/{branch}', 'BranchController@update')->name('faculty.update');
    Route::post('/delete/{branch}', 'BranchController@destroy')->name('faculty.delete');
});

Route::group([
    'prefix' => 'bieu-mau',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('', 'BieuMauController@index')->name('bieu-mau.index');
    Route::post('', 'BieuMauController@store')->name('bieu-mau.store');
    Route::delete('{model}', 'BieuMauController@destroy')->name('bieu-mau.destroy');
});
Route::group([
    'prefix' => 'tom-tat-chi-so',
    'middleware' => 'jwt.auth'
], function () {
    Route::get('{year}', 'TomTatController@show')->name('tom-tat.index');
    Route::post('{year}', 'TomTatController@update')->name('tom-tat.update');
    Route::post('{year}/tinh-toan', 'TomTatController@tinhToan')->name('tom-tat.tinhtoan');
});

Route::group([
    'prefix' => 'bao-cao-ba-cong-khai',
    'middleware' => 'jwt.auth'
], function () {
    Route::post('{year}', 'BaCongKhaiController@submit')->name('ba-cong-khai.submit');
    Route::post('/export/{year}', 'BaCongKhaiController@export')->name('ba-cong-khai.export');
    Route::get('history/{year}', 'BaCongKhaiController@submitHistory')->name('ba-cong-khai.submit-history');
});


