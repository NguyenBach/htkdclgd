<?php

namespace Modules\NghienCuuKhoaHoc\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Helper\AuthHelper;

class TapChiDuocDangPolicy extends BasePolicy
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

    public function tap_chi_duoc_dang(User $user)
    {
        return AuthHelper::can($user, 'tap_chi_duoc_dang');
    }
}
