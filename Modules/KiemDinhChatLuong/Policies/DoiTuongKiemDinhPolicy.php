<?php

namespace Modules\KiemDinhChatLuong\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Helper\AuthHelper;

class DoiTuongKiemDinhPolicy extends BasePolicy
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

    public function doi_tuong_kiem_dinh(User $user)
    {
        return AuthHelper::can($user, 'kiem_dinh_chat_luong');
    }
}
