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

Route::get('/test', function () {
    return view('test');
});


\Illuminate\Support\Facades\Route::any('/webhook', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Log::info($request->method());
    \Illuminate\Support\Facades\Log::info(json_encode($request->all()));
    \Illuminate\Support\Facades\Log::info(json_encode($request->header()));

    $curl = curl_init();
    $jsonEncodedData = json_encode($request->all());
    $url = 'https://api.dev.gobysend.com/api/payment/invoice/notify';

    $opts = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => $jsonEncodedData,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Content-Length: ' . strlen($jsonEncodedData)],
    ];

    curl_setopt_array($curl, $opts);

    $result = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);

    \Illuminate\Support\Facades\Log::info(json_encode($result));
    \Illuminate\Support\Facades\Log::info($status);
});

\Illuminate\Support\Facades\Route::any('/image', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Log::info(json_encode($request));
    \Illuminate\Support\Facades\Log::info(json_encode(\request()->headers));
    $imagePath = public_path('images/opens.gif');

    return response()
        ->file($imagePath, [
            'Content-Type' => 'image/gif',
            'Content-Length' => 0,
            'Cache-Control' => 'no-cache, no-store, must-revalidate, post-check=0, pre-check=0, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => 0,
        ]);
});
