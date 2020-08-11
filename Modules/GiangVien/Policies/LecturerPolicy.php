<?php

namespace Modules\GiangVien\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Helper\AuthHelper;
use Modules\GiangVien\Entities\Lecturer;

class LecturerPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        //
    }

    public function lecturer(User $user)
    {
        return AuthHelper::can($user, 'lecturer');
    }

    public function lecturer_update(User $user, Lecturer $lecturer)
    {
        if ($user->university_id != $lecturer->university_id) {
            return false;
        }
        return AuthHelper::can($user, 'lecturer');
    }
}
