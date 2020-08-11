<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 27/05/2019
 * Time: 20:49
 */

namespace Modules\NghienCuuKhoaHoc\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Modules\NghienCuuKhoaHoc\Entities\BangSangChe;
use Modules\NghienCuuKhoaHoc\Entities\BaoCaoHoiThao;
use Modules\NghienCuuKhoaHoc\Entities\CanBoHoiThao;
use Modules\NghienCuuKhoaHoc\Entities\CanBoNCKH;
use Modules\NghienCuuKhoaHoc\Entities\CanBoTapChi;
use Modules\NghienCuuKhoaHoc\Entities\DoanhThuNCKH;
use Modules\NghienCuuKhoaHoc\Entities\SoLuongNCKH;
use Modules\NghienCuuKhoaHoc\Entities\SoLuongSach;
use Modules\NghienCuuKhoaHoc\Entities\SvNCKH;
use Modules\NghienCuuKhoaHoc\Entities\TapChiDuocDang;
use Modules\NghienCuuKhoaHoc\Entities\ThanhTich;
use Modules\NghienCuuKhoaHoc\Policies\BangSangChePolicy;
use Modules\NghienCuuKhoaHoc\Policies\BaoCaoHoiThaoPolicy;
use Modules\NghienCuuKhoaHoc\Policies\CanBoHoiThaoPolicy;
use Modules\NghienCuuKhoaHoc\Policies\CanBoNCKHPolicy;
use Modules\NghienCuuKhoaHoc\Policies\CanBoTapChiPolicy;
use Modules\NghienCuuKhoaHoc\Policies\DoanhThuNCKHPolicy;
use Modules\NghienCuuKhoaHoc\Policies\SoLuongNCKHPolicy;
use Modules\NghienCuuKhoaHoc\Policies\SoLuongSachPolicy;
use Modules\NghienCuuKhoaHoc\Policies\SvNCKHPolicy;
use Modules\NghienCuuKhoaHoc\Policies\TapChiDuocDangPolicy;
use Modules\NghienCuuKhoaHoc\Policies\ThanhTichPolicy;


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
        SoLuongSach::class => SoLuongSachPolicy::class,
        TapChiDuocDang::class => TapChiDuocDangPolicy::class,
        CanBoTapChi::class => CanBoTapChiPolicy::class,
        BaoCaoHoiThao::class => BaoCaoHoiThaoPolicy::class,
        CanBoHoiThao::class => CanBoHoiThaoPolicy::class,
        BangSangChe::class => BangSangChePolicy::class,
        SvNCKH::class => SvNCKHPolicy::class,
        ThanhTich::class => ThanhTichPolicy::class,
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