<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 02/06/2019
 * Time: 23:08
 */

namespace Modules\Auth\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Entities\Role;

class RoleController extends Controller
{
    public function __construct()
    {
    }

    public function list()
    {
//        $this->authorize('list', Permission::class);
        $user = Auth::user();
        $roles = Role::all()
            ->reject(function ($role) use ($user) {
                return !in_array($user->role_id, json_decode($role->role_base));
            });

        $result = [
            'success' => true,
            'message' => 'Lấy thông tin thành công',
            'data' => [
                'roles' => $roles
            ]
        ];
        return response()->json($result, 200);
    }
}