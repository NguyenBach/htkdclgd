<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 02/06/2019
 * Time: 22:07
 */

namespace Modules\Auth\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Entities\Permission;
use Modules\Auth\Http\Helper\AuthHelper;

class PermissionController extends Controller
{

    public function __construct()
    {
    }

    public function list(Request $request)
    {
        $this->authorize('list', Permission::class);
        $roleId = $request->input('role') ?? 1;
        $permissions = Permission::all()
            ->reject(function ($permission) use ($roleId) {
                return !in_array($roleId, json_decode($permission->role_base));
            });
        $user = Auth::user();

        $data = [];
        foreach ($permissions as $permission) {
            if (in_array($user->role_id, json_decode($permission->role_base, true))) {
                $data[] = $permission;
            }
        }
        $result = [
            'success' => true,
            'message' => 'Lấy thông tin thành công',
            'data' => [
                'permissions' => $data
            ]
        ];
        return response()->json($result, 200);
    }
}