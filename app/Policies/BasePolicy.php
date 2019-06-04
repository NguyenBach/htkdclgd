<?php

namespace App\Policies;

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
        if (AuthHelper::isSuperAdmin($user)) {
            return true;
        }

    }
}
