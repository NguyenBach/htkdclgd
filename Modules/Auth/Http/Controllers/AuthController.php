<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\Auth\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {

        $credentials = $request->validated();

        if (!$token = Auth::attempt($credentials)) {
            Log::info('Đăng nhập thất bại');
            $response = [
                'success' => false,
                'code' => 401,
                'message' => 'Unauthorized'
            ];
            return response()->json($response, 401);
        }

        Log::info('Đăng nhập thành công');
        activity()->log('heloworld');

        $response = [
            'success' => true,
            'code' => 200,
            'message' => 'Login Success',
            'access_token' => $token,
            'user' => Auth::user()
        ];
        return response()->json($response, 200);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();
        $response = [
            'success' => true,
            'code' => 200,
            'message' => 'Successfully logged out',
        ];
        Log::info('Đăng xuất thành công');
        return response()->json($response, 200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $token = Auth::refresh();
        Log::info('Làm mới token thành công');

        $response = [
            'success' => true,
            'code' => 200,
            'message' => 'Login Success',
            'access_token' => $token
        ];
        return response()->json($response, 200);
    }


}
