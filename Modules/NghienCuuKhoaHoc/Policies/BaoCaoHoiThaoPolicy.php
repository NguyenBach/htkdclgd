<?php

namespace Modules\NghienCuuKhoaHoc\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Helper\AuthHelper;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class BaoCaoHoiThaoPolicy extends BasePolicy
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

    public function bao_cao_hoi_thao(User $user)
    {
        return AuthHelper::can($user, 'bao_cao_hoi_thao');
    }
}
