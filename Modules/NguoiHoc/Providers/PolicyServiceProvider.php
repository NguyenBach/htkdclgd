<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 27/05/2019
 * Time: 20:49
 */

namespace Modules\NguoiHoc\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Modules\Auth\Entities\Permission;
use Modules\Auth\Entities\User;
use Modules\Auth\Policies\PermissionPolicy;
use Modules\Auth\Policies\UserPolicy;
use Modules\NguoiHoc\Entities\NguoiHocTotNghiep;
use Modules\NguoiHoc\Entities\SvKtx;
use Modules\NguoiHoc\Entities\SvNhapHoc;
use Modules\NguoiHoc\Entities\SvThamGiaNCKH;
use Modules\NguoiHoc\Entities\TinhTrangSvTotNghiep;
use Modules\NguoiHoc\Policies\NguoiHocTotNghiepPolicy;
use Modules\NguoiHoc\Policies\SvKtxPolicy;
use Modules\NguoiHoc\Policies\SvNhapHocPolicy;
use Modules\NguoiHoc\Policies\SvThamGiaNCKHPolicy;
use Modules\NguoiHoc\Policies\TinhTrangSvTotNghiepPolicy;


class PolicyServiceProvider extends AuthServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        SvNhapHoc::class => SvNhapHocPolicy::class,
        SvKtx::class => SvKtxPolicy::class,
        SvThamGiaNCKH::class => SvThamGiaNCKHPolicy::class,
        NguoiHocTotNghiep::class => NguoiHocTotNghiepPolicy::class,
        TinhTrangSvTotNghiep::class => TinhTrangSvTotNghiepPolicy::class,
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