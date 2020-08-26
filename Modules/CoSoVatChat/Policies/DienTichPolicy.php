<?php

namespace Modules\CoSoVatChat\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Helper\AuthHelper;

class DienTichPolicy extends BasePolicy
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

    public function dien_tich(User $user)
    {
        return AuthHelper::can($user, 'dien_tich');
    }

    public function update(User $user)
    {
        return AuthHelper::isUniversityManager($user);
    }

    public function index(User $user)
    {
        return AuthHelper::isCAE($user)
            || AuthHelper::isExpert($user)
            || AuthHelper::isUniversityManager($user);
    }
}
