<?php

namespace Modules\ThongTinChung\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Helper\AuthHelper;
use Modules\ThongTinChung\Entities\Faculty;

class EducationTypePolicy
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
    }


    public function education_type(User $user)
    {
        return AuthHelper::can($user, 'faculty');
    }

    public function education_type_update(User $user, Faculty $faculty)
    {
        return AuthHelper::can($user, 'faculty') && $faculty->university_id == $user->university_id;
    }

    public function list(User $user)
    {
        return AuthHelper::can($user, 'faculty');
    }
}
