<?php

namespace Modules\NguoiHoc\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Helper\AuthHelper;

class SvThamGiaNCKHPolicy extends BasePolicy
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

    public function sv_tham_gia_nckh(User $user)
    {
        return AuthHelper::can($user, 'sv_tham_gia_nckh');
    }
}
