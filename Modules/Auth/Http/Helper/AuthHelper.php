<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 21/05/2019
 * Time: 20:58
 */

namespace Modules\Auth\Http\Helper;


use Modules\Auth\Entities\User;

class AuthHelper
{

    public static function isSuperAdmin($user)
    {
        if ($user->role_id == 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function isUniversityManager($user)
    {
        if ($user->role_id == 3) {
            return true;
        } else {
            return false;
        }
    }

    public static function isAdmin($user)
    {
        if ($user->role_id == 2) {
            return true;
        } else {
            return false;
        }
    }

    public static function checkRoleIsNotAdmin($role)
    {
        if ($role !== 1 && $role !== 2) {
            return true;
        } else {
            return false;
        }
    }

    public static function can(User $user, $ability)
    {
        $userRole = $user->roles()->first();
        $permission = json_decode($userRole->permissions) ?? [];
        return in_array($ability, $permission);
    }
}