<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 27/05/2019
 * Time: 20:49
 */

namespace Modules\CoSoVatChat\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Modules\CoSoVatChat\Entities\DienTich;
use Modules\CoSoVatChat\Entities\NhomNganh;
use Modules\CoSoVatChat\Entities\SachThuVien;
use Modules\CoSoVatChat\Entities\ThietBi;
use Modules\CoSoVatChat\Entities\ThuChi;
use Modules\CoSoVatChat\Entities\TrangThietBi;
use Modules\CoSoVatChat\Policies\DienTichPolicy;
use Modules\CoSoVatChat\Policies\NhomNganhPolicy;
use Modules\CoSoVatChat\Policies\SachThuVienPolicy;
use Modules\CoSoVatChat\Policies\ThietBiPolicy;
use Modules\CoSoVatChat\Policies\ThuChiPolicy;
use Modules\CoSoVatChat\Policies\TrangThietBiPolicy;
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
        DienTich::class => DienTichPolicy::class,
        SachThuVien::class => SachThuVienPolicy::class,
        ThietBi::class => ThietBiPolicy::class,
        TrangThietBi::class => TrangThietBiPolicy::class,
        ThuChi::class => ThuChiPolicy::class,
        NhomNganh::class => NhomNganhPolicy::class
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
