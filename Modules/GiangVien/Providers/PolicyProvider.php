<?php

namespace Modules\GiangVien\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Modules\GiangVien\Entities\Lecturer;
use Modules\GiangVien\Entities\LecturerByAge;
use Modules\GiangVien\Entities\LecturerByDegree;
use Modules\GiangVien\Entities\LecturerByFl;
use Modules\GiangVien\Entities\Officer;
use Modules\GiangVien\Entities\OfficerByGender;
use Modules\GiangVien\Policies\LecturerByAgePolicy;
use Modules\GiangVien\Policies\LecturerByDegreePolicy;
use Modules\GiangVien\Policies\LecturerByFlPolicy;
use Modules\GiangVien\Policies\LecturerPolicy;
use Modules\GiangVien\Policies\OfficerByGenderPolicy;
use Modules\GiangVien\Policies\OfficerPolicy;

class PolicyProvider extends AuthServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    protected $policies = [
        Lecturer::class => LecturerPolicy::class,
        Officer::class => OfficerPolicy::class,
        OfficerByGender::class => OfficerByGenderPolicy::class,
        LecturerByDegree::class => LecturerByDegreePolicy::class,
        LecturerByAge::class => LecturerByAgePolicy::class,
        LecturerByFl::class => LecturerByFlPolicy::class,
    ];


    public function boot()
    {
        $this->registerPolicies();
        //
    }
}
