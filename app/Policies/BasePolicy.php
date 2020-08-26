<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Entities\User;
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
        if (AuthHelper::isSuperAdmin($user) || AuthHelper::isAdmin($user)) {
            return true;
        }
    }

    public function index(User $user)
    {
        return AuthHelper::isExpert($user)
            || AuthHelper::isUniversityManager($user)
            || AuthHelper::isCAE($user);
    }

    public function create(User $user)
    {
        return AuthHelper::isCAE($user)
            || AuthHelper::isUniversityManager($user);
    }

    public function store(User $user)
    {
        return AuthHelper::isCAE($user)
            || AuthHelper::isUniversityManager($user);
    }

    public function update(User $user)
    {
        return AuthHelper::isCAE($user)
            || AuthHelper::isUniversityManager($user);
    }
}
