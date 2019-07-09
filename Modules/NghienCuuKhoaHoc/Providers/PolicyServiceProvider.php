<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 27/05/2019
 * Time: 20:49
 */

namespace Modules\NghienCuuKhoaHoc\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Modules\NghienCuuKhoaHoc\Entities\CanBoNCKH;
use Modules\NghienCuuKhoaHoc\Entities\DoanhThuNCKH;
use Modules\NghienCuuKhoaHoc\Entities\SoLuongNCKH;
use Modules\NghienCuuKhoaHoc\Policies\CanBoNCKHPolicy;
use Modules\NghienCuuKhoaHoc\Policies\DoanhThuNCKHPolicy;
use Modules\NghienCuuKhoaHoc\Policies\SoLuongNCKHPolicy;


class PolicyServiceProvider extends AuthServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        SoLuongNCKH::class => SoLuongNCKHPolicy::class,
        DoanhThuNCKH::class => DoanhThuNCKHPolicy::class,
        CanBoNCKH::class => CanBoNCKHPolicy::class,
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