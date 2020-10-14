<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 20/05/2019
 * Time: 23:37
 */

namespace Modules\Auth\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Auth\Entities\Permission;
use Modules\Auth\Entities\User;
use Modules\Auth\Entities\UserPermission;
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
        $user->permissions = $user->permissions()->get();
        Log::info("Lấy thông tin cá nhân thành công");
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
        $user = User::where('id', $id)->with('university')->first();
        $user->permissions = $user->permissions()->get();
        if (is_null($user)) {
            Log::info("Lấy thông tin cá nhân thất bại");

            $result = [
                'success' => false,
                'message' => 'Không tìm thấy người dùng này'
            ];
            return response()->json($result, 404);
        } else {
            Log::info("Lấy thông tin cá nhân thành công");
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
            if ($userInfo['role_id'] < 3) {
                $userInfo['role_id'] = 4;
            }
        }

        $userInfo['password'] = bcrypt($userInfo['password']);
        $userInfo['created_by'] = $user->id;
        if (AuthHelper::isSuperAdmin($user) || AuthHelper::isAdmin($user)) {
            $basePermission = Permission::all()
                ->reject(function ($permission) use ($userInfo) {
                    return !in_array($userInfo['role_id'], json_decode($permission->role_base));
                })
                ->map(function ($permission) {
                    return $permission->id;
                })->toArray();
        } else {
            $basePermission = $user->permissions()->get()
                ->reject(function ($permission) use ($userInfo) {
                    return !in_array($userInfo['role_id'], json_decode($permission->role_base));
                })
                ->map(function ($permission) {
                    return $permission->id;
                })->toArray();
        }

        $createdUser = null;
        DB::transaction(function () use ($userInfo, &$createdUser, $basePermission) {
            $createdUser = User::create($userInfo);
            if (isset($userInfo['permissions'])) {
                $userPermissions = json_decode($userInfo['permissions']);
                foreach ($userPermissions as $permission) {
                    if (in_array($permission, $basePermission)) {
                        $data = [
                            'user_id' => $createdUser->id,
                            'permission_id' => $permission
                        ];
                        UserPermission::updateOrCreate($data);
                    }
                }
            }
            $createdUser->permissions = $createdUser->permissions()->get();

        });

        if (is_null($createdUser)) {
            Log::info("Thêm người dùng");

            $result = [
                'success' => false,
                'message' => 'Thêm người dùng lỗi'
            ];
            return response()->json($result, 404);
        } else {
            Log::info("Thêm người dùng");

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
                $userInfo['role_id'] = 4;
            }
        }
        if (AuthHelper::isSuperAdmin($authUser) || AuthHelper::isAdmin($authUser)) {
            $basePermission = Permission::all()
                ->reject(function ($permission) use ($userInfo) {
                    return !in_array($userInfo['role_id'], json_decode($permission->role_base));
                })
                ->map(function ($permission) {
                    return $permission->id;
                })->toArray();
        } else {
            $basePermission = $authUser->permissions()->get()
                ->reject(function ($permission) use ($userInfo) {
                    return !in_array($userInfo['role_id'], json_decode($permission->role_base));
                })
                ->map(function ($permission) {
                    return $permission->id;
                })->toArray();
        }
        $updatedUser = $user->update($userInfo);

        if (isset($userInfo['permissions'])) {
            $userPermissions = json_decode($userInfo['permissions']);
            foreach ($userPermissions as $permission) {
                if (in_array($permission, $basePermission)) {
                    $data = [
                        'user_id' => $user->id,
                        'permission_id' => $permission
                    ];
                    echo $permission;
                    UserPermission::updateOrCreate($data);
                }
            }
        }
        $user->refresh();
        $user->permissions = $user->permissions()->get();
        if (is_null($updatedUser)) {
            $result = [
                'success' => false,
                'message' => 'Sửa người dùng lỗi'
            ];
            return response()->json($result, 404);
        } else {
            $result = [
                'success' => true,
                'message' => 'Sửa người dùng thành công',
                'data' => [
                    'user' => $user
                ]
            ];
            return response()->json($result, 200);
        }
    }

    public function list()
    {
        $this->authorize('list', User::class);
        $currentUser = Auth::user();
        if (AuthHelper::isSuperAdmin($currentUser) || AuthHelper::isAdmin($currentUser)) {
            $listUser = User::with('university')
                ->orderBy('university_id')
                ->get();
        } else {
            $listUser = User::where('created_by', $currentUser->id)
                ->where('university_id', $currentUser->university_id)
                ->get();
        }
        $result = [
            'success' => true,
            'message' => 'Lấy danh sách người dùng thành công',
            'data' => [
                'users' => $listUser
            ]
        ];
        return response()->json($result, 200);

    }

    public function delete(User $user)
    {
        $this->authorize('delete', $user);
        $currentUser = Auth::user();
        if ($currentUser->id === $user->id) {
            $result = [
                'success' => false,
                'message' => 'Không thể tự xóa tài khoản của mình',
            ];
            return response()->json($result, 400);
        }

        $success = $user->delete();

        if ($success) {
            $result = [
                'success' => true,
                'message' => 'Xóa người dùng thành công',
            ];
            return response()->json($result, 200);
        } else {
            $result = [
                'success' => false,
                'message' => 'Xóa người dùng thất bại',
            ];
            return response()->json($result, 500);
        }
    }
}
