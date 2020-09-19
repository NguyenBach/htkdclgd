<?php

namespace Modules\ThongTinChung\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Helper\AuthHelper;
use Modules\ThongTinChung\Entities\Faculty;

class FacultyPolicy extends BasePolicy
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

    public function faculty(User $user)
    {
        return true;
    }

    public function faculty_update(User $user, Faculty $faculty)
    {
        return AuthHelper::can($user, 'faculty') && $faculty->university_id == $user->university_id;
    }

    public function list(User $user)
    {
        return AuthHelper::can($user, 'faculty');
    }
}
