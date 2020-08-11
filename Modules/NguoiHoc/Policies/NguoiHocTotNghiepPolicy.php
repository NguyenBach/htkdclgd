<?php

namespace Modules\NguoiHoc\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Helper\AuthHelper;

class NguoiHocTotNghiepPolicy extends BasePolicy
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

    public function nguoi_hoc_tot_nghiep(User $user)
    {
        return AuthHelper::can($user, 'nguoi_hoc_tot_nghiep');
    }
}
