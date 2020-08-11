<?php

namespace Modules\NguoiHoc\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Helper\AuthHelper;

class SvNhapHocPolicy extends BasePolicy
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

    public function sv_nhap_hoc(User $user)
    {
        return AuthHelper::can($user, 'sv_nhap_hoc');
    }
}
