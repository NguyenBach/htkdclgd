<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
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
            $response = [
                'success' => false,
                'code' => 401,
                'message' => 'Unauthorized'
            ];
            return response()->json($response, 401);
        }

        $response = [
            'success' => true,
            'code' => 200,
            'message' => 'Login Success',
            'access_token' => $token
        ];
        return response()->json($response, 200);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = Auth::user();
        $response = [
            'success' => true,
            'code' => 200,
            'message' => 'Get user info success',
            'user' => $user
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
        $response = [
            'success' => true,
            'code' => 200,
            'message' => 'Login Success',
            'access_token' => $token
        ];
        return response()->json($response, 200);
    }


}
