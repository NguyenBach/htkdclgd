<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Helper\AuthHelper;
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
                'code' => 400,
                'message' => 'Tài khoản hoặc mật khẩu không đúng'
            ];
            return response()->json($response, 200);
        }

        Log::info('Đăng nhập thành công');

        $response = [
            'success' => true,
            'code' => 200,
            'message' => 'Đăng nhập thành công',
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
            'message' => 'Đăng xuất thành công',
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
            'message' => 'Đăng nhập thành công ',
            'access_token' => $token
        ];
        return response()->json($response, 200);
    }

    public function resetPassword(User $user, Request $request)
    {
        $currentUser = Auth::user();
        if (AuthHelper::isSuperAdmin($currentUser) || AuthHelper::isAdmin($currentUser)) {
            $newPassword = Str::random(8);
            $user->password = Hash::make($newPassword);
            $user->save();
            $response = [
                'success' => true,
                'code' => 200,
                'message' => 'Tạo mới mật khẩu thành công',
                'newPassword' => $newPassword
            ];
            return response()->json($response, 200);
        }
        $response = [
            'success' => true,
            'code' => 403,
            'message' => 'Hành động không được phép',
        ];
        return response()->json($response, 403);
    }

    public function changePassword(Request $request)
    {

        if (!(Hash::check($request->get('old_password'), Auth::user()->password))) {
            // The passwords matches
            $response = [
                'success' => false,
                'code' => 200,
                'message' => 'Mật khẩu không đúng',
            ];
            return response()->json($response, 200);
        }

        if (strcmp($request->get('old_password'), $request->get('new_password')) == 0) {
            //Current password and new password are same
            $response = [
                'success' => false,
                'code' => 200,
                'message' => 'Không thể sử dụng mật khẩu cũ',
            ];
            return response()->json($response, 200);
        }

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new_password'));
        $user->save();

        $response = [
            'success' => true,
            'code' => 200,
            'message' => 'Đổi mật khẩu thành công',
        ];
        return response()->json($response, 200);
    }


}
