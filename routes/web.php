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

Route::get('/', function () {
    return view('frontend::index');
});

\Illuminate\Support\Facades\Route::any('/webhook', function (\Illuminate\Http\Request $request) {
   \Illuminate\Support\Facades\Log::info($request->method());
   \Illuminate\Support\Facades\Log::info(json_encode($request->all()));
   \Illuminate\Support\Facades\Log::info(json_encode($request->header()));
//   \Illuminate\Support\Facades\Log::info(json_encode($request->));
});
