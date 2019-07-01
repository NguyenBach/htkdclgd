<?php

namespace App\Policies;

use Modules\Auth\Entities\Permission;
use Modules\Auth\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Auth\Http\Helper\AuthHelper;

class BasePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function before(User $user, $ability)
    {
        $permission = Permission::where('permission', $ability)->first();
        $roleBase = json_decode($permission->role_base);
        if (!in_array($user->role_id, $roleBase)) {
            return false;
        }

        if (AuthHelper::isSuperAdmin($user) || AuthHelper::isUniversityManager($user)) {
            return true;
        }

    }
}
