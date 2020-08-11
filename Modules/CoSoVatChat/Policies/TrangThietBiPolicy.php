<?php

namespace Modules\CoSoVatChat\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Helper\AuthHelper;
use Modules\CoSoVatChat\Entities\TrangThietBi;

class TrangThietBiPolicy extends BasePolicy
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

    public function trang_thiet_bi(User $user)
    {
        return AuthHelper::can($user, 'thiet_bi');
    }

    public function trang_thiet_bi_update(User $user, TrangThietBi $trangThietBi)
    {
        return AuthHelper::can($user, 'thiet_bi') && $user->id == $trangThietBi->created_by;
    }
}
