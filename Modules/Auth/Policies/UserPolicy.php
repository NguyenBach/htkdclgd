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

    public function list(User $user)
    {
        return AuthHelper::can($user, 'user:list');
    }

    public function delete(User $user, User $deleteUser)
    {
        $a = AuthHelper::can($user, 'user:delete');
        if (!$a) {
            return false;
        }
        if (AuthHelper::isUniversityManager($user) || AuthHelper::isUniversityOfficer($user)) {
            if ($user->university_id === $deleteUser->university_id) {
                return true;
            } else {
                return false;
            }
        }else{
            return $a;
        }
    }

}
