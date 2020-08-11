<?php

namespace Modules\ThongTinChung\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Helper\AuthHelper;
use Modules\ThongTinChung\Entities\Branch;

class BranchPolicy extends BasePolicy
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

    public function branch(User $user)
    {
        return AuthHelper::can($user, 'branch');
    }

    public function branch_update(User $user, Branch $branch)
    {
        return AuthHelper::can($user, 'branch') && $user->university_id == $branch->university_id;
    }
}
