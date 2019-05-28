<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 20/05/2019
 * Time: 23:37
 */

namespace Modules\Auth\Http\Controllers;


use App\Http\Controllers\Controller;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Entities\User;
use Modules\Auth\Entities\UserRole;
use Modules\Auth\Http\Helper\AuthHelper;
use Modules\Auth\Http\Requests\CreateUserRequest;
use Modules\Auth\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    private $user = null;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function me()
    {
        $user = Auth::user();
        $result = [
            'success' => true,
            'message' => 'Lấy thông tin người dùng thành công',
            'data' => [
                'user' => $user
            ]
        ];
        return response()->json($result, 200);
    }

    public function profile($id)
    {
        $this->authorize('view_profile', Auth::user());
        $user = $this->user->find($id);
        if (is_null($user)) {
            $result = [
                'success' => false,
                'message' => 'Không tìm thấy người dùng này'
            ];
            return response()->json($result, 404);
        } else {
            $result = [
                'success' => true,
                'message' => 'Lấy thông tin người dùng thành công',
                'data' => [
                    'user' => $user
                ]
            ];
            return response()->json($result, 200);
        }
    }

    public function create(CreateUserRequest $request)
    {
        $userInfo = $request->validated();
        $user = Auth::user();
        $this->authorize('create', $user);

        if (AuthHelper::isUniversityManager($user)) {
            $userInfo['university_id'] = $user->university_id;
        } else {
            $universityId = $request->input('university_id') ?? 0;
            $userInfo['university_id'] = $universityId;
        }

        if ($userInfo['university_id'] != 0) {
            if ($userInfo['roles'] < 3) {
                $userInfo['roles'] = 0;
            }
        }

        $userInfo['password'] = bcrypt($userInfo['password']);
        $userInfo['created_by'] = $user->id;

        $createdUser = User::create($userInfo);

        if (is_null($createdUser)) {
            $result = [
                'success' => false,
                'message' => 'Thêm người dùng lỗi'
            ];
            return response()->json($result, 404);
        } else {
            $result = [
                'success' => true,
                'message' => 'Thêm người dùng thành công',
                'data' => [
                    'user' => $createdUser
                ]
            ];
            return response()->json($result, 200);
        }
    }

    public function update(User $user, UpdateUserRequest $request)
    {
        $authUser = Auth::user();
        $this->authorize('update', $authUser, $user);
        $userInfo = $request->validated();
        if (isset($userInfo['username'])) {
            unset($userInfo['username']);
        }
        if (isset($userInfo['password'])) {
            unset($userInfo['password']);
        }

        if (AuthHelper::isUniversityManager($authUser)) {
            $userInfo['university_id'] = $authUser->university_id;
        } else {
            $universityId = $request->input('university_id') ?? $user->university_id;
            $userInfo['university_id'] = $universityId;
        }
        if ($userInfo['university_id'] != 0) {
            if ($userInfo['role_id'] < 3) {
                $userInfo['role_id'] = 0;
            }
        }
        $updatedUser = $user->update($userInfo);
        if (is_null($updatedUser)) {
            $result = [
                'success' => false,
                'message' => 'Thêm người dùng lỗi'
            ];
            return response()->json($result, 404);
        } else {
            $result = [
                'success' => true,
                'message' => 'Thêm người dùng thành công',
                'data' => [
                    'user' => $updatedUser
                ]
            ];
            return response()->json($result, 200);
        }
    }
}