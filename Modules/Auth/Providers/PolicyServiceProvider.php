<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 27/05/2019
 * Time: 20:49
 */

namespace Modules\Auth\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Modules\Auth\Entities\Permission;
use Modules\Auth\Entities\User;
use Modules\Auth\Policies\PermissionPolicy;
use Modules\Auth\Policies\UserPolicy;


class PolicyServiceProvider extends AuthServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Permission::class => PermissionPolicy::class
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