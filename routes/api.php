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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

\Illuminate\Support\Facades\Route::any('/webhook', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Log::info($request->method());
    \Illuminate\Support\Facades\Log::info(json_encode($request->all()));
    \Illuminate\Support\Facades\Log::info(json_encode($request->header()));
    $response =  \Illuminate\Support\Facades\Http::post('https://api.dev.gobysend.com/api/payment/invoice/notify',$request->all());
   \Illuminate\Support\Facades\Log::info(json_encode($response));
});

