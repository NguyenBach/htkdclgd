<?php

namespace Modules\Auth\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Helper\AuthHelper;

class PermissionPolicy
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
        if (AuthHelper::isSuperAdmin($user)) {
            return true;
        }

    }


    public function list(User $user)
    {
        return AuthHelper::can($user, 'permission:list');
    }
}
