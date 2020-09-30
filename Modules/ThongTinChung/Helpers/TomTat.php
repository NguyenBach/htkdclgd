<?php


namespace Modules\ThongTinChung\Helpers;


use Modules\CoSoVatChat\Entities\DienTich;
use Modules\GiangVien\Entities\Lecturer;
use Modules\GiangVien\Entities\LecturerByDegree;
use Modules\GiangVien\Entities\Officer;
use Modules\NghienCuuKhoaHoc\Entities\BaoCaoHoiThao;
use Modules\NghienCuuKhoaHoc\Entities\DoanhThuNCKH;
use Modules\NghienCuuKhoaHoc\Entities\SoLuongNCKH;
use Modules\NghienCuuKhoaHoc\Entities\SoLuongSach;
use Modules\NghienCuuKhoaHoc\Entities\TapChiDuocDang;
use Modules\NguoiHoc\Entities\SvKtx;
use Modules\NguoiHoc\Entities\TinhTrangSvTotNghiep;

class TomTat
{

    public static function tongGiangVienCoHuu($universityId, $year)
    {
        $giangVien = Lecturer::where('university_id', $universityId)
            ->where('year', $year)
            ->first();
        if ($giangVien) {
            return $giangVien->total_1;
        }
        return 0;
    }

    public static function tongGianVienTrenTongCanBo($universityId, $year)
    {
        $canBoCoHuu = Officer::where('university_id', $universityId)
            ->where('year', $year)
            ->first();
        if (!$canBoCoHuu) {
            $canBoCoHuu = new \stdClass();
            $canBoCoHuu->quan_ly_co_huu = 0;
            $canBoCoHuu->nhan_vien_co_huu = 0;
        }

        $quanLyCoHuu = $canBoCoHuu->quan_ly_co_huu;
        $nhanhVienCoHuu = $canBoCoHuu->nhan_vien_co_huu;
        $giangVienCoHuu = self::tongGiangVienCoHuu($universityId, $year);
        $tongCanBo = $giangVienCoHuu + $quanLyCoHuu + $nhanhVienCoHuu;
        if (!$tongCanBo) {
            return -1;
        }
        return round(($giangVienCoHuu / $tongCanBo), 2);
    }

    public static function tongCanBoCoHuu($universityId, $year)
    {
        $canBoCoHuu = Officer::where('university_id', $universityId)
            ->where('year', $year)
            ->first();
        if (!$canBoCoHuu) {
            $canBoCoHuu = new \stdClass();
            $canBoCoHuu->quan_ly_co_huu = 0;
            $canBoCoHuu->nhan_vien_co_huu = 0;
        }

        $quanLyCoHuu = $canBoCoHuu->quan_ly_co_huu;
        $nhanhVienCoHuu = $canBoCoHuu->nhan_vien_co_huu;
        $giangVienCoHuu = self::tongGiangVienCoHuu($universityId, $year);
        return $giangVienCoHuu + $quanLyCoHuu + $nhanhVienCoHuu;
    }

    public static function tiLeGiangVienTienSi($universityId, $year)
    {
        $giangVien = Lecturer::where('university_id', $universityId)
            ->where('year', $year)
            ->first();
        if ($giangVien) {
            return $giangVien->percent_doctor_1;
        }
        return -1;
    }

    public static function tiLeGiangVienThacSi($universityId, $year)
    {
        $giangVienCoHuu = self::tongGiangVienCoHuu($universityId, $year);
        $giangVienTheoTrinhDo = LecturerByDegree::where('university_id', $universityId)
            ->where('year', $year)
            ->where('lecturer_type', 1)
            ->first();
        $soLuongThacSi = $giangVienTheoTrinhDo ? $giangVienTheoTrinhDo->master : 0;
        return $giangVienCoHuu > 0 ? round($soLuongThacSi / $giangVienCoHuu, 3) * 100 : -1;
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
        return -1;
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
        $nckh = SoLuongNCKH::where('universityId', $universityId)
            ->where('year', $year)->get();
        $tong = $nckh->reduce(function ($carry, $item) {
            return $carry + $item->dt_cap_nha_nuoc + $item->dt_cap_bo + $item->dt_cap_truong;
        });

        if ($tongCanBo > 0) {
            return round($tong / $tongCanBo, 2);
        }

        return -1;
    }

    public static function tiSoSachCanBo($universityId, $year)
    {
        $tongCanBo = self::tongCanBoCoHuu($universityId, $year);
        $sach = SoLuongSach::where('universityId', $universityId)
            ->where('year', $year)->get();
        $tong = $sach->reduce(function ($carry, $item) {
            return $carry + $item->so_luong;
        });

        if ($tongCanBo > 0) {
            return round($tong / $tongCanBo, 2);
        }

        return -1;
    }

    public static function tiSoBaiDangTapChi($universityId, $year)
    {
        $tongCanBo = self::tongCanBoCoHuu($universityId, $year);
        $sach = TapChiDuocDang::where('universityId', $universityId)
            ->where('year', $year)->get();
        $tong = $sach->reduce(function ($carry, $item) {
            return $carry + $item->so_luong;
        });

        if ($tongCanBo > 0) {
            return round($tong / $tongCanBo, 2);
        }

        return -1;
    }

    public static function tiSoBaoCaoHoiThao($universityId, $year)
    {
        $tongCanBo = self::tongCanBoCoHuu($universityId, $year);
        $sach = BaoCaoHoiThao::where('universityId', $universityId)
            ->where('year', $year)->get();
        $tong = $sach->reduce(function ($carry, $item) {
            return $carry + $item->so_luong;
        });

        if ($tongCanBo > 0) {
            return round($tong / $tongCanBo, 2);
        }

        return -1;
    }

    public static function tiSoDoanhThu($universityId, $year)
    {
        $doanhThu = DoanhThuNCKH::where('university_id', $universityId)
            ->where('year', $year)->first();
        return $doanhThu ? $doanhThu->ti_so_tren_cb_ch : -1;
    }

    public static function tiSoDienTichSV($universityId, $year)
    {
        $tongSv = self::tongSoSinhVienChinhQuy($universityId, $year);
        $dienTich = DienTich::where('university_id', $universityId)
            ->where('year', $year)->where('noi_dung', 3)->first();
        if (!$tongSv) {
            return -1;
        }
        $s = $dienTich ? $dienTich->dien_tich : 0;
        return round($s / $tongSv, 2);
    }

    public static function tiSoKTXSV($universityId, $year)
    {
        $sv = SvKtx::where('university_id', $universityId)->where('year', $year)->first();
        if (!$sv) {
            return -1;
        }
        return 0;
    }

}
