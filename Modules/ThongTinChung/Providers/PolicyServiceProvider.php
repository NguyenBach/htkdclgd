<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 27/05/2019
 * Time: 20:49
 */

namespace Modules\ThongTinChung\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Modules\ThongTinChung\Entities\Department;
use Modules\ThongTinChung\Entities\KeyOfficer;
use Modules\ThongTinChung\Entities\University;
use Modules\ThongTinChung\Policies\DepartmentPolicy;
use Modules\ThongTinChung\Policies\KeyOfficerPolicy;
use Modules\ThongTinChung\Policies\UniversityPolicy;


class PolicyServiceProvider extends AuthServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        University::class => UniversityPolicy::class,
        Department::class => DepartmentPolicy::class,
        KeyOfficer::class => KeyOfficerPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //
    }
}