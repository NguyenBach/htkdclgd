<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 02/07/2019
 * Time: 21:45
 */

namespace Modules\NguoiHoc\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\NguoiHoc\Entities\SvNhapHoc;
use Modules\NguoiHoc\Http\Requests\SvNhapHocRequest;

class SVNhapHocController extends Controller
{
    public function index($heHoc, $year)
    {
        if ($heHoc == 'chinh-quy') {
            $heHoc = 1;
        } else if ($heHoc == 'khong-chinh-quy') {
            $heHoc = 0;
        } else {
            $result = [
                'success' => false,
                'message' => 'Hệ học không tồn tại'
            ];
            return response()->json($result, 404);
        }
        $user = Auth::user();
        $this->authorize('sv_nhap_hoc', SvNhapHoc::class);
        $ncs = SvNhapHoc::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('he_hoc', $heHoc)
            ->where('type', 'NCS')
            ->first();

        $hvch = SvNhapHoc::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('he_hoc', $heHoc)
            ->where('type', 'HVCH')
            ->first();

        $dh = SvNhapHoc::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('he_hoc', $heHoc)
            ->where('type', 'DH')
            ->first();

        $cd = SvNhapHoc::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('he_hoc', $heHoc)
            ->where('type', 'CD')
            ->first();
        $tc = SvNhapHoc::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('he_hoc', $heHoc)
            ->where('type', 'TC')
            ->first();
        $khac = SvNhapHoc::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('he_hoc', $heHoc)
            ->where('type', 'KHAC')
            ->first();
        $result = [
            'success' => true,
            'message' => 'Lấy người học thành công',
            'data' => [
                'ncs' => $ncs,
                'hvch' => $hvch,
                'dh' => $dh,
                'cd' => $cd,
                'tc' => $tc,
                'khac' => $khac,
            ]
        ];
        return response()->json($result, 200);
    }


    public function store($heHoc, $year, SvNhapHocRequest $request)
    {
        if ($heHoc == 'chinh-quy') {
            $heHoc = 1;
        } else if ($heHoc == 'khong-chinh-quy') {
            $heHoc = 0;
        } else {
            $result = [
                'success' => false,
                'message' => 'Hệ học không tồn tại'
            ];
            return response()->json($result, 404);
        }

        $user = Auth::user();
        $this->authorize('sv_nhap_hoc', SvNhapHoc::class);
        $data = $request->validated();
        $insertData = [];
        $insertData['university_id'] = $user->university_id;
        $insertData['year'] = $year;
        $insertData['he_hoc'] = $heHoc;

        $ncs = json_decode($data['ncs'], true);
        $insertData['type'] = 'NCS';
        $insertData['sl_du_tuyen'] = $ncs['sl_du_tuyen'] ?? 0;
        $insertData['sl_trung_tuyen'] = $ncs['sl_trung_tuyen'] ?? 0;
        $insertData['sl_nhap_hoc'] = $ncs['sl_nhap_hoc'] ?? 0;
        $insertData['sl_sv_quoc_te'] = $ncs['sl_sv_quoc_te'] ?? 0;
        $insertData['diem_dau_vao'] = $ncs['diem_dau_vao'] ?? 0;
        $insertData['diem_trung_binh'] = $ncs['diem_trung_binh'] ?? 0;
        $insertData['ty_le_canh_tranh'] = $ncs['ty_le_canh_tranh'] ?? 0;


        $ncs = SvNhapHoc::updateOrCreate(
            [
                'year' => $year,
                'type' => 'NCS',
                'he_hoc' => $heHoc,
                'university_id' => $user->university_id
            ],
            $insertData);

        $hvch = json_decode($data['hvch'], true);
        $insertData['type'] = 'HVCH';
        $insertData['sl_du_tuyen'] = $hvch['sl_du_tuyen'] ?? 0;
        $insertData['sl_trung_tuyen'] = $hvch['sl_trung_tuyen'] ?? 0;
        $insertData['sl_nhap_hoc'] = $hvch['sl_nhap_hoc'] ?? 0;
        $insertData['sl_sv_quoc_te'] = $hvch['sl_sv_quoc_te'] ?? 0;
        $insertData['diem_dau_vao'] = $hvch['diem_dau_vao'] ?? 0;
        $insertData['diem_trung_binh'] = $hvch['diem_trung_binh'] ?? 0;
        $insertData['ty_le_canh_tranh'] = $hvch['ty_le_canh_tranh'] ?? 0;


        $hvch = SvNhapHoc::updateOrCreate(
            [
                'year' => $year,
                'type' => 'HVCH',
                'he_hoc' => $heHoc,
                'university_id' => $user->university_id
            ],
            $insertData);

        $dh = json_decode($data['dh'], true);
        $insertData['type'] = 'DH';
        $insertData['sl_du_tuyen'] = $dh['sl_du_tuyen'] ?? 0;
        $insertData['sl_trung_tuyen'] = $dh['sl_trung_tuyen'] ?? 0;
        $insertData['sl_nhap_hoc'] = $dh['sl_nhap_hoc'] ?? 0;
        $insertData['sl_sv_quoc_te'] = $dh['sl_sv_quoc_te'] ?? 0;
        $insertData['diem_dau_vao'] = $dh['diem_dau_vao'] ?? 0;
        $insertData['diem_trung_binh'] = $dh['diem_trung_binh'] ?? 0;
        $insertData['ty_le_canh_tranh'] = $dh['ty_le_canh_tranh'] ?? 0;


        $dh = SvNhapHoc::updateOrCreate(
            [
                'year' => $year,
                'type' => 'DH',
                'he_hoc' => $heHoc,
                'university_id' => $user->university_id
            ],
            $insertData);

        $cd = json_decode($data['cd'], true);
        $insertData['type'] = 'CD';
        $insertData['sl_du_tuyen'] = $cd['sl_du_tuyen'] ?? 0;
        $insertData['sl_trung_tuyen'] = $cd['sl_trung_tuyen'] ?? 0;
        $insertData['sl_nhap_hoc'] = $cd['sl_nhap_hoc'] ?? 0;
        $insertData['sl_sv_quoc_te'] = $cd['sl_sv_quoc_te'] ?? 0;
        $insertData['diem_dau_vao'] = $cd['diem_dau_vao'] ?? 0;
        $insertData['diem_trung_binh'] = $cd['diem_trung_binh'] ?? 0;
        $insertData['ty_le_canh_tranh'] = $cd['ty_le_canh_tranh'] ?? 0;


        $cd = SvNhapHoc::updateOrCreate(
            [
                'year' => $year,
                'type' => 'CD',
                'he_hoc' => $heHoc,
                'university_id' => $user->university_id
            ],
            $insertData);

        $tc = json_decode($data['tc'], true);
        $insertData['type'] = 'TC';
        $insertData['sl_du_tuyen'] = $tc['sl_du_tuyen'] ?? 0;
        $insertData['sl_trung_tuyen'] = $tc['sl_trung_tuyen'] ?? 0;
        $insertData['sl_nhap_hoc'] = $tc['sl_nhap_hoc'] ?? 0;
        $insertData['sl_sv_quoc_te'] = $tc['sl_sv_quoc_te'] ?? 0;
        $insertData['diem_dau_vao'] = $tc['diem_dau_vao'] ?? 0;
        $insertData['diem_trung_binh'] = $tc['diem_trung_binh'] ?? 0;
        $insertData['ty_le_canh_tranh'] = $tc['ty_le_canh_tranh'] ?? 0;


        $tc = SvNhapHoc::updateOrCreate(
            [
                'year' => $year,
                'type' => 'TC',
                'he_hoc' => $heHoc,
                'university_id' => $user->university_id
            ],
            $insertData);

        $khac = json_decode($data['khac'], true);
        $insertData['type'] = 'KHAC';
        $insertData['sl_du_tuyen'] = $khac['sl_du_tuyen'] ?? 0;
        $insertData['sl_trung_tuyen'] = $khac['sl_trung_tuyen'] ?? 0;
        $insertData['sl_nhap_hoc'] = $khac['sl_nhap_hoc'] ?? 0;
        $insertData['sl_sv_quoc_te'] = $khac['sl_sv_quoc_te'] ?? 0;
        $insertData['diem_dau_vao'] = $khac['diem_dau_vao'] ?? 0;
        $insertData['diem_trung_binh'] = $khac['diem_trung_binh'] ?? 0;
        $insertData['ty_le_canh_tranh'] = $khac['ty_le_canh_tranh'] ?? 0;


        $khac = SvNhapHoc::updateOrCreate(
            [
                'year' => $year,
                'type' => 'KHAC',
                'he_hoc' => $heHoc,
                'university_id' => $user->university_id
            ],
            $insertData);

        $result = [
            'success' => true,
            'message' => 'Update người học thành công',
            'data' => [
                'ncs' => $ncs,
                'hvch' => $hvch,
                'dh' => $dh,
                'cd' => $cd,
                'tc' => $tc,
                'khac' => $khac,
            ]
        ];
        return response()->json($result, 200);
    }
}