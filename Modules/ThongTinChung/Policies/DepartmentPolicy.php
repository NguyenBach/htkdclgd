<?php

namespace Modules\ThongTinChung\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Helper\AuthHelper;
use Modules\ThongTinChung\Entities\Department;

class DepartmentPolicy extends BasePolicy
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
        parent::__construct();
    }

    public function list(User $user)
    {
        return AuthHelper::can($user, 'key_officer.create') || AuthHelper::can($user, 'key_officer.update');

    }

    public function create(User $user)
    {
        return AuthHelper::can($user, 'key_officer.create') || AuthHelper::can($user, 'key_officer.update');

    }

    public function update(User $user, Department $model)
    {
        $a = AuthHelper::can($user, 'key_officer.create') || AuthHelper::can($user, 'key_officer.update');
        if (!AuthHelper::isSuperAdmin($user) || !AuthHelper::isAdmin($user)) {
            $b = $user->university_id == $model->university_id;
        } else {
            $b = true;
        }
        return $a && $b;
    }

    public function view(User $user, Department $model)
    {
        $a = AuthHelper::can($user, 'key_officer.create') || AuthHelper::can($user, 'key_officer.update');
        if (!AuthHelper::isSuperAdmin($user) || !AuthHelper::isAdmin($user)) {
            $b = $user->university_id == $model->university_id;
        } else {
            $b = true;
        }
        return $a && $b;
    }

    public function delete(User $user, Department $department)
    {
        $a = AuthHelper::can($user, 'key_officer.create') || AuthHelper::can($user, 'key_officer.update');
        if (!AuthHelper::isSuperAdmin($user) || !AuthHelper::isAdmin($user)) {
            $b = $user->university_id == $department->university_id;
        } else {
            $b = true;
        }
        return $a && $b;
    }
}
