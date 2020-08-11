<?php

namespace Modules\CoSoVatChat\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Helper\AuthHelper;

class SachThuVienPolicy extends BasePolicy
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

    public function sach_thu_vien(User $user)
    {
        return AuthHelper::can($user, 'sach_thu_vien');
    }
}
