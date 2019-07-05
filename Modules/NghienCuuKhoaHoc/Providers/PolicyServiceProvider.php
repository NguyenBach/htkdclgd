<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 27/05/2019
 * Time: 20:49
 */

namespace Modules\NghienCuuKhoaHoc\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;


class PolicyServiceProvider extends AuthServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [

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