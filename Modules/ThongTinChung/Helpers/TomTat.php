<?php


namespace Modules\ThongTinChung\Helpers;


use Modules\GiangVien\Entities\Lecturer;
use Modules\GiangVien\Entities\LecturerByDegree;
use Modules\GiangVien\Entities\Officer;

class TomTat
{

    public function tongGiangVienCoHuu($universityId, $year)
    {
        $giangVien = Lecturer::where('university_id', $universityId)
            ->where('year', $year)
            ->first();
        if ($giangVien) {
            return $giangVien->total_1;
        }
        return 0;
    }

    public function tongGianVienTrenTongCanBo($universityId, $year)
    {
        $canBoCoHuu = Officer::where('university_id', $universityId)
            ->where('year', $year)
            ->first();
        if ($canBoCoHuu) {
            $canBoCoHuu = new \stdClass();
            $canBoCoHuu->quan_ly_co_huu = 0;
            $canBoCoHuu->nhan_vien_co_huu = 0;
        }

        $quanLyCoHuu = $canBoCoHuu->quan_ly_co_huu;
        $nhanhVienCoHuu = $canBoCoHuu->nhanh_vien_co_huu;
        $giangVienCoHuu = $this->tongGiangVienCoHuu($universityId, $year);
        $tongCanBo = $giangVienCoHuu + $quanLyCoHuu + $nhanhVienCoHuu;
        if (!$tongCanBo) {
            return -1;
        }
        return round(($giangVienCoHuu / $tongCanBo), 2);
    }

    public function tiLeGiangVienTienSi($universityId, $year)
    {
        $giangVien = Lecturer::where('university_id', $universityId)
            ->where('year', $year)
            ->first();
        if ($giangVien) {
            return $giangVien->percent_doctor_1;
        }
        return -1;
    }

    public function tiLeGiangVienThacSi($universityId, $year)
    {
        $giangVienCoHuu = $this->tongGiangVienCoHuu($universityId, $year);
        $giangVienTheoTrinhDo = LecturerByDegree::where('university_id', $universityId)
            ->where('year', $year)
            ->where('lecturer_type', 1)
            ->first();
        $soLuongThacSi = $giangVienTheoTrinhDo ? $giangVienTheoTrinhDo->master : 0;
        return $giangVienCoHuu > 0 ? round($soLuongThacSi / $giangVienCoHuu, 2) : -1;
    }

    public function tongSoSinhVienChinhQuy($universityId, $year)
    {

    }


}
