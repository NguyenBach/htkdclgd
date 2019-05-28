<?php

namespace Modules\Auth\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Helper\AuthHelper;
use Modules\Auth\Providers\PolicyServiceProvider;

class UserPolicy
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

    public function view_profile(User $user)
    {
        return AuthHelper::can($user, 'user:view_profile');
    }

    public function create(User $user)
    {
        return AuthHelper::can($user, 'user:create');
    }

    public function update(User $user, User $userUpdated)
    {
        $allow = AuthHelper::can($user, 'user:update');
        if (!$allow) {
            if ($user->id === $userUpdated->id) {
                $allow = true;
            } else {
                $allow = false;
            }
        }
        return $allow;
    }

}
