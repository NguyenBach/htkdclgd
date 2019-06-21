<?php

namespace Modules\GiangVien\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Modules\GiangVien\Entities\Lecturer;
use Modules\GiangVien\Policies\LecturerPolicy;

class PolicyProvider extends AuthServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    protected $policies = [
        Lecturer::class => LecturerPolicy::class
    ];


    public function boot()
    {
        $this->registerPolicies();
        //
    }
}
