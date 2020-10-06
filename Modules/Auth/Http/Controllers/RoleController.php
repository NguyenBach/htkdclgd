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
        $roles = Role::all();

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
