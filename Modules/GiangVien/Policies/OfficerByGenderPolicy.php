<?php

namespace Modules\GiangVien\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Helper\AuthHelper;

class OfficerByGenderPolicy extends BasePolicy
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

    public function officer_by_gender(User $user)
    {
        return AuthHelper::can($user, 'officer_by_gender');
    }
}
