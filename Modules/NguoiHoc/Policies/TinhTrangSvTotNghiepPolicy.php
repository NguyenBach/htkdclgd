<?php

namespace Modules\NguoiHoc\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Helper\AuthHelper;

class TinhTrangSvTotNghiepPolicy extends BasePolicy
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

    public function tinh_trang_sv_tn(User $user)
    {
        return AuthHelper::can($user, 'tinh_trang_sv_tn');
    }
}

