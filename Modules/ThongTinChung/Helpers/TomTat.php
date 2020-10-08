<?php


namespace Modules\ThongTinChung\Helpers;


use Illuminate\Support\Facades\Cache;
use Modules\CoSoVatChat\Entities\DienTich;
use Modules\GiangVien\Entities\Lecturer;
use Modules\GiangVien\Entities\LecturerByAge;
use Modules\GiangVien\Entities\LecturerByDegree;
use Modules\GiangVien\Entities\Officer;
use Modules\GiangVien\Entities\OfficerByGender;
use Modules\NghienCuuKhoaHoc\Entities\BaoCaoHoiThao;
use Modules\NghienCuuKhoaHoc\Entities\DoanhThuNCKH;
use Modules\NghienCuuKhoaHoc\Entities\SoLuongNCKH;
use Modules\NghienCuuKhoaHoc\Entities\SoLuongSach;
use Modules\NghienCuuKhoaHoc\Entities\TapChiDuocDang;
use Modules\NguoiHoc\Entities\SvKtx;
use Modules\NguoiHoc\Entities\TinhTrangSvTotNghiep;
use Modules\ThongTinChung\Entities\TomTatChiSo;

class TomTat
{

    public static function tomTat($universityId, $year)
    {
        $tomTat = TomTatChiSo::where('university_id', $universityId)
            ->where('year', $year)->first();
        if (!$tomTat) {
            $tomTat = new TomTatChiSo();
            $tomTat->university_id = $universityId;
            $tomTat->year = $year;
        }

        //Tinh toan o day
        $tomTat->tong_gv_co_huu = self::tongGiangVienCoHuu($universityId, $year);
        $tomTat->tong_cb_co_huu = self::tongCanBoCoHuu($universityId, $year);
        $tomTat->ti_le_gv_cb = self::tongGianVienTrenTongCanBo($universityId, $year);
        $tomTat->ti_le_gv_ts = self::tiLeGiangVienTienSi($universityId, $year);
        $tomTat->ti_le_gv_ths = self::tiLeGiangVienThacSi($universityId, $year);
        $tomTat->tong_sv = self::tongSoSinhVienChinhQuy($universityId, $year);
        $tomTat->ti_le_sv_gv = self::tiLeSvGv($universityId, $year);
        $tomTat->ti_le_tot_nghiep = self::tiLeTotNghiep($universityId, $year);
        $tomTat->ti_le_tra_loi_duoc = self::tiLeTraLoiDuoc($universityId, $year);
        $tomTat->ti_le_tra_loi_1_phan = self::tiLeTraLoiDuoc1Phan($universityId, $year);
        $tomTat->ti_le_dung_nganh = self::tiLeDungNganh($universityId, $year);
        $tomTat->ti_le_trai_nganh = self::tiLeTraiNganh($universityId, $year);
        $tomTat->ti_le_tu_tao = self::tiLeTuTao($universityId, $year);
        $tomTat->thu_nhap_binh_quan = self::thuNhapTrungBinh($universityId, $year);
        $tomTat->ti_le_dap_ung_ngay = self::tiLeDapUngNgay($universityId, $year);
        $tomTat->ti_le_dao_tao_them = self::tiLeDaoTaoThem($universityId, $year);
        $tomTat->ti_le_de_tai_cb = self::tiLeDeTaiCanBo($universityId, $year);
        $tomTat->ti_so_sach_cb = self::tiSoSachCanBo($universityId, $year);
        $tomTat->ti_so_tap_chi_cb = self::tiSoBaiDangTapChi($universityId, $year);
        $tomTat->ti_so_bai_bao_cb = self::tiSoBaoCaoHoiThao($universityId, $year);
        $tomTat->ti_so_doanh_thu = self::tiSoDoanhThu($universityId, $year);
        $tomTat->ti_so_dien_tich_sv = self::tiSoDienTichSV($universityId, $year);
        $tomTat->ti_so_ktx_sv = self::tiSoKTXSV($universityId, $year);
//        'cap_co_so',
//        'cap_ctdt'

        $tomTat->save();
        $tomTat->refresh();
        $cacheKey = "tom_tat:university_{$universityId}_{$year}";
        Cache::forever($cacheKey, $tomTat);
        return $tomTat;
    }

    public static function get($universityId, $year, $key, $default)
    {
        $cacheKey = "tom_tat:university_{$universityId}_{$year}";
        if (Cache::has($cacheKey)) {
            $tomTat = Cache::get($cacheKey);
        } else {
            $tomTat = TomTatChiSo::where('university_id', $universityId)
                ->where('year', $year)->first();
        }
        if (!$tomTat) {
            return $default;
        }
        if (in_array($key, $tomTat->getFillable())) {
            return $tomTat->$key;
        }
        return $default;
    }

    public static function save($universityId, $year, $key, $value)
    {
        $cacheKey = "tom_tat:university_{$universityId}_{$year}";
        if (Cache::has($cacheKey)) {
            $tomTat = Cache::get($cacheKey);
        } else {
            $tomTat = TomTatChiSo::where('university_id', $universityId)
                ->where('year', $year)->first();
        }
        if (!$tomTat) {
            $tomTat = new TomTatChiSo();
            $tomTat->university_id = $universityId;
            $tomTat->year = $year;
        }
        if (in_array($key, $tomTat->getFillable())) {
            $tomTat->$key = $value;
        }
        $tomTat->save();
        $tomTat->refresh();
        Cache::forever($cacheKey, $tomTat);
        return $tomTat;
    }

    public static function tongGiangVienCoHuu($universityId, $year)
    {
        $giangVien = LecturerByDegree::where('university_id', $universityId)
            ->where('year', $year)
            ->whereIn('lecturer_type', [1, 2, 3])
            ->get();
        if ($giangVien) {
            return $giangVien->reduce(function ($carry, $item) {
                return $carry + $item->professor + $item->associate_professor
                    + $item->science_doctor + $item->doctor + $item->master + $item->undergraduate
                    + $item->college + $item->intermediate + $item->other;
            });
        }
        return 0;
    }

    public static function tongGianVienTrenTongCanBo($universityId, $year)
    {
        $canBoCoHuu = self::tongCanBoCoHuu($universityId, $year);
        $giangVienCoHuu = self::tongGiangVienCoHuu($universityId, $year);

        if (!$canBoCoHuu) {
            return 0;
        }
        return round(($giangVienCoHuu / $canBoCoHuu), 3) * 100;
    }

    public static function tongCanBoCoHuu($universityId, $year)
    {
        $canBoCoHuu = OfficerByGender::where('university_id', $universityId)
            ->where('year', $year)
            ->first();
        if (!$canBoCoHuu) {
            $canBoCoHuu = new \stdClass();
            $canBoCoHuu->bien_che_nam = 0;
            $canBoCoHuu->bien_che_nu = 0;
            $canBoCoHuu->dai_han_nam = 0;
            $canBoCoHuu->dai_han_nu = 0;
        }

        return $canBoCoHuu->bien_che_nam + $canBoCoHuu->bien_che_nu + $canBoCoHuu->dai_han_nam + $canBoCoHuu->dai_han_nu;
    }

    public static function tiLeGiangVienTienSi($universityId, $year)
    {
        $giangVien = LecturerByAge::where('university_id', $universityId)
            ->where('year', $year)
            ->get();
        $tongTienSi = 0;
        $tongGV = 0;
        foreach ($giangVien as $item) {
            $tongGV += $item->total;
            if (in_array($item->lecturer_degree, [1, 2, 3, 4])) {
                $tongTienSi += $item->total;
            }
        }
        if ($tongGV == 0) {
            return 0;
        }
        return round($tongTienSi / $tongGV, 3) * 100;
    }

    public static function tiLeGiangVienThacSi($universityId, $year)
    {
        $giangVien = LecturerByAge::where('university_id', $universityId)
            ->where('year', $year)
            ->get();
        $tongThs = 0;
        $tongGV = 0;
        foreach ($giangVien as $item) {
            $tongGV += $item->total;
            if ($item->lecturer_degree == 5) {
                $tongThs += $item->total;
            }
        }
        if ($tongGV == 0) {
            return 0;
        }
        return round($tongThs / $tongGV, 3) * 100;
    }

    public static function tongSoSinhVienChinhQuy($universityId, $year)
    {
        $sv = SvKtx::where('university_id', $universityId)
            ->where('year', $year)->first();
        return $sv ? $sv->sl_sinh_vien : 0;
    }

    public static function tiLeSvGv($universityId, $year)
    {
        $giangVienTheoTrinhDo = LecturerByDegree::where('university_id', $universityId)
            ->where('year', $year)
            ->get();
        $tongGV = $giangVienTheoTrinhDo->reduce(function ($carry, $item) {
            return $carry + $item->professor + $item->associate_professor
                + $item->science_doctor + $item->doctor + $item->master + $item->undergraduate + $item->college
                + $item->intermediate + $item->other;
        });
        $tongSv = self::tongSoSinhVienChinhQuy($universityId, $year);
        if ($tongGV) {
            return round($tongSv / $tongGV, 3) * 100;
        }
        return 0;
    }

    public static function tiLeTotNghiep($universityId, $year)
    {
        $svTotNghiep = TinhTrangSvTotNghiep::where('university_id', $universityId)
            ->where('year', $year)
            ->where('cau_hoi_id', 2)
            ->first();
        return $svTotNghiep ? $svTotNghiep->tra_loi : 0;
    }

    public static function tiLeTraLoiDuoc($universityId, $year)
    {
        $svTotNghiep = TinhTrangSvTotNghiep::where('university_id', $universityId)
            ->where('year', $year)
            ->where('cau_hoi_id', 3)
            ->first();
        return $svTotNghiep ? $svTotNghiep->tra_loi : 0;
    }

    public static function tiLeTraLoiDuoc1Phan($universityId, $year)
    {
        $svTotNghiep = TinhTrangSvTotNghiep::where('university_id', $universityId)
            ->where('year', $year)
            ->where('cau_hoi_id', 4)
            ->first();
        return $svTotNghiep ? $svTotNghiep->tra_loi : 0;
    }

    public static function tiLeDungNganh($universityId, $year)
    {
        $svTotNghiep = TinhTrangSvTotNghiep::where('university_id', $universityId)
            ->where('year', $year)
            ->where('cau_hoi_id', 7)
            ->first();
        return $svTotNghiep ? $svTotNghiep->tra_loi : 0;
    }

    public static function tiLeTraiNganh($universityId, $year)
    {
        $svTotNghiep = TinhTrangSvTotNghiep::where('university_id', $universityId)
            ->where('year', $year)
            ->where('cau_hoi_id', 8)
            ->first();
        return $svTotNghiep ? $svTotNghiep->tra_loi : 0;
    }

    public static function tiLeTuTao($universityId, $year)
    {
        $svTotNghiep = TinhTrangSvTotNghiep::where('university_id', $universityId)
            ->where('year', $year)
            ->where('cau_hoi_id', 9)
            ->first();
        return $svTotNghiep ? $svTotNghiep->tra_loi : 0;
    }

    public static function thuNhapTrungBinh($universityId, $year)
    {
        $svTotNghiep = TinhTrangSvTotNghiep::where('university_id', $universityId)
            ->where('year', $year)
            ->where('cau_hoi_id', 10)
            ->first();
        return $svTotNghiep ? $svTotNghiep->tra_loi : 0;
    }

    public static function tiLeDapUngNgay($universityId, $year)
    {
        $svTotNghiep = TinhTrangSvTotNghiep::where('university_id', $universityId)
            ->where('year', $year)
            ->where('cau_hoi_id', 11)
            ->first();
        return $svTotNghiep ? $svTotNghiep->tra_loi : 0;
    }

    public static function tiLeDaoTaoThem($universityId, $year)
    {
        $svTotNghiep = TinhTrangSvTotNghiep::where('university_id', $universityId)
            ->where('year', $year)
            ->where('cau_hoi_id', 12)
            ->first();
        return $svTotNghiep ? $svTotNghiep->tra_loi : 0;
    }

    public static function tiLeDeTaiCanBo($universityId, $year)
    {
        $tongCanBo = self::tongCanBoCoHuu($universityId, $year);
        $nckh = SoLuongNCKH::where('university_id', $universityId)
            ->where('year', $year)->get();
        $tong = $nckh->reduce(function ($carry, $item) {
            return $carry + $item->dt_cap_nha_nuoc + $item->dt_cap_bo + $item->dt_cap_truong;
        });

        if ($tongCanBo > 0) {
            return round($tong / $tongCanBo, 2);
        }

        return 0;
    }

    public static function tiSoSachCanBo($universityId, $year)
    {
        $tongCanBo = self::tongCanBoCoHuu($universityId, $year);
        $sach = SoLuongSach::where('university_id', $universityId)
            ->where('year', $year)->get();
        $tong = $sach->reduce(function ($carry, $item) {
            return $carry + $item->so_luong;
        });

        if ($tongCanBo > 0) {
            return round($tong / $tongCanBo, 2);
        }

        return 0;
    }

    public static function tiSoBaiDangTapChi($universityId, $year)
    {
        $tongCanBo = self::tongCanBoCoHuu($universityId, $year);
        $sach = TapChiDuocDang::where('university_id', $universityId)
            ->where('year', $year)->get();
        $tong = $sach->reduce(function ($carry, $item) {
            return $carry + $item->so_luong;
        });

        if ($tongCanBo > 0) {
            return round($tong / $tongCanBo, 2);
        }

        return 0;
    }

    public static function tiSoBaoCaoHoiThao($universityId, $year)
    {
        $tongCanBo = self::tongCanBoCoHuu($universityId, $year);
        $sach = BaoCaoHoiThao::where('university_id', $universityId)
            ->where('year', $year)->get();
        $tong = $sach->reduce(function ($carry, $item) {
            return $carry + $item->so_luong;
        });

        if ($tongCanBo > 0) {
            return round($tong / $tongCanBo, 2);
        }

        return 0;
    }

    public static function tiSoDoanhThu($universityId, $year)
    {
        $doanhThu = DoanhThuNCKH::where('university_id', $universityId)
            ->where('year', $year)->first();
        return $doanhThu ? $doanhThu->ti_so_tren_cb_ch : 0;
    }

    public static function tiSoDienTichSV($universityId, $year)
    {
        $tongSv = self::tongSoSinhVienChinhQuy($universityId, $year);
        $dienTich = DienTich::where('university_id', $universityId)
            ->where('year', $year)->where('noi_dung', 3)->first();
        if (!$tongSv) {
            return 0;
        }
        $s = $dienTich ? $dienTich->dien_tich : 0;
        return round($s / $tongSv, 2);
    }

    public static function tiSoKTXSV($universityId, $year)
    {
        $sv = SvKtx::where('university_id', $universityId)->where('year', $year)->first();
        if (!$sv) {
            return 0;
        }
        return 0;
    }

}
