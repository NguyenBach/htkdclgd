<?php

namespace Modules\ThongTinChung\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Helper\AuthHelper;
use Modules\ThongTinChung\Entities\University;

class UniversityPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if (AuthHelper::isSuperAdmin($user) || AuthHelper::isAdmin($user)) {
            return true;
        }
    }

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function list(User $user)
    {
        return AuthHelper::isCAE($user) || AuthHelper::isAdmin($user) || AuthHelper::isSuperAdmin($user);
    }

    public function create(User $user)
    {
        return AuthHelper::isSuperAdmin($user) || AuthHelper::isAdmin($user);
    }

    public function update(User $user, University $university = null)
    {
        $can =AuthHelper::isSuperAdmin($user) || AuthHelper::isAdmin($user) || AuthHelper::isUniversityManager($user)
            || AuthHelper::isUniversityOfficer($user);
        if ($can) {
            if ($user->university_id == 0) {
                return true;
            } else {
                if ($user->university_id == $university->id) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    public function view(User $user, University $university)
    {
//        $can = AuthHelper::can($user, 'university:view');
        $can = true;
        if ($can) {
            if ($user->university_id == 0) {
                return true;
            } else {
                if ($user->university_id == $university->id) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    public function delete(User $user)
    {
        return AuthHelper::can($user, 'university:delete');
    }
}
