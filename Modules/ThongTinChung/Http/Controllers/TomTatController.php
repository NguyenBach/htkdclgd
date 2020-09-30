<?php


namespace Modules\ThongTinChung\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Modules\ThongTinChung\Entities\TomTatChiSo;
use Modules\ThongTinChung\Helpers\TomTat;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TomTatController extends Controller
{

    public function show($year)
    {
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $tomTat = TomTatChiSo::where('university_id', $universityId)
            ->where('year', $year)->first();

        $result = [
            'success' => true,
            'message' => 'Lấy thông tin thành công',
            'data' => [
                'tom_tat' => $tomTat
            ]
        ];
        return response()->json($result, 200);
    }

    public function update($year, Request $request)
    {
        $data = $request->all();
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $tomTat = TomTatChiSo::where('university_id', $universityId)
            ->where('year', $year)->first();
        if (!$tomTat) {
            $tomTat = new TomTatChiSo();
            $tomTat->university_id = $universityId;
            $tomTat->year = $year;
        }

        foreach ($data as $key => $value) {
            if (in_array($key, $tomTat->getFillable())) {
                $tomTat->$key = $value;
            }
        }

        $tomTat->save();
        $tomTat->refresh();
        $result = [
            'success' => true,
            'message' => 'Lấy thông tin thành công',
            'data' => [
                'tom_tat' => $tomTat
            ]
        ];
        return response()->json($result, 200);
    }

    public function tinhToan($year)
    {
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $tomTat = TomTatChiSo::where('university_id', $universityId)
            ->where('year', $year)->first();
        if (!$tomTat) {
            $tomTat = new TomTatChiSo();
            $tomTat->university_id = $universityId;
            $tomTat->year = $year;
        }

        //Tinh toan o day
        $tomTat->tong_gv_co_huu = TomTat::tongGiangVienCoHuu($universityId, $year);
        $tomTat->ti_le_gv_cb = TomTat::tongGianVienTrenTongCanBo($universityId, $year);
        $tomTat->ti_le_gv_ts = TomTat::tiLeGiangVienTienSi($universityId, $year);
        $tomTat->ti_le_gv_ths = TomTat::tiLeGiangVienThacSi($universityId, $year);
        $tomTat->tong_sv = TomTat::tongSoSinhVienChinhQuy($universityId, $year);
        $tomTat->ti_le_sv_gv = TomTat::tiLeSvGv($universityId, $year);
        $tomTat->ti_le_tot_nghiep = TomTat::tiLeTotNghiep($universityId, $year);
        $tomTat->ti_le_tra_loi_duoc = TomTat::tiLeTraLoiDuoc($universityId, $year);
        $tomTat->ti_le_tra_loi_1_phan = TomTat::tiLeTraLoiDuoc1Phan($universityId, $year);
        $tomTat->ti_le_dung_nganh = TomTat::tiLeDungNganh($universityId, $year);
        $tomTat->ti_le_trai_nganh = TomTat::tiLeTraiNganh($universityId, $year);
        $tomTat->ti_le_tu_tao = TomTat::tiLeTuTao($universityId, $year);
        $tomTat->thu_nhap_binh_quan = TomTat::thuNhapTrungBinh($universityId, $year);
        $tomTat->ti_le_dap_ung_ngay = TomTat::tiLeDapUngNgay($universityId, $year);
        $tomTat->ti_le_dao_tao_them = TomTat::tiLeDaoTaoThem($universityId, $year);
        $tomTat->ti_le_de_tai_cb = TomTat::tiLeDeTaiCanBo($universityId, $year);
        $tomTat->ti_so_sach_cb = TomTat::tiSoSachCanBo($universityId, $year);
        $tomTat->ti_so_tap_chi_cb = TomTat::tiSoBaiDangTapChi($universityId, $year);
        $tomTat->ti_so_bai_bao_cb = TomTat::tiSoBaoCaoHoiThao($universityId, $year);
        $tomTat->ti_so_doanh_thu = TomTat::tiSoDoanhThu($universityId, $year);
        $tomTat->ti_so_dien_tich_sv = TomTat::tiSoDienTichSV($universityId, $year);
        $tomTat->ti_so_ktx_sv = TomTat::tiSoKTXSV($universityId, $year);
//        'cap_co_so',
//        'cap_ctdt'

        $tomTat->save();
        $tomTat->refresh();
        $result = [
            'success' => true,
            'message' => 'Lấy thông tin thành công',
            'data' => [
                'tom_tat' => $tomTat
            ]
        ];
        return response()->json($result, 200);
    }
}
