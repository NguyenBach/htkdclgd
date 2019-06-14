<?php

namespace Modules\ThongTinChung\Policies;

use App\Policies\BasePolicy;
use const http\Client\Curl\AUTH_ANY;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Helper\AuthHelper;
use Modules\ThongTinChung\Entities\KeyOfficer;

class KeyOfficerPolicy extends BasePolicy
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

    public function key_officer(User $user)
    {
        return AuthHelper::can($user, 'key_officer');
    }

    public function key_officer_update(User $user, KeyOfficer $keyOfficer)
    {
        return AuthHelper::can($user, 'key_officer') && $keyOfficer->university_id == $user->university_id;
    }

    public function list(User $user)
    {
        return AuthHelper::can($user, 'key_officer');
    }
}
