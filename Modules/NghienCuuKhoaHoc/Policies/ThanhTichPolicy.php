<?php

namespace Modules\NghienCuuKhoaHoc\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Helper\AuthHelper;

class ThanhTichPolicy extends BasePolicy
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

    public function thanh_tich_nckh(User $user)
    {
        return AuthHelper::can($user, 'thanh_tich_nckh');
    }
}
