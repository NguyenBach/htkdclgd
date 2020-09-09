<?php

namespace Modules\TuDanhGia\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Modules\TuDanhGia\Entities\TuDanhGiaDraft;

class TuDanhGiaController extends Controller
{

    public function index($tieuChuan)
    {
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
        }
        $tuDanhGia = TuDanhGiaDraft::where('university_id', $universityId)
            ->where('role', $user->role_id)
            ->where('tieu_chuan', $tieuChuan)
            ->get();

        $result = [
            'success' => true,
            'message' => "Lấy thông tin thành công",
            'data' => $tuDanhGia
        ];
        return \response()->json($result);
    }


    public function create($tieuChuan, Request $request)
    {
        $data = $request->json();
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = $request->get('university_id');
        }
        $insertData = [
            'university_id' => $universityId,
            'role' => $user->role_id,
            'tieu_chuan' => $tieuChuan
        ];
        foreach ($data as $tieuChi) {
            $insertData['tieu_chi'] = $tieuChi['id'];
            $insertData['diem_thong_nhat'] = $tieuChi['diem_thong_nhat'];
            if (isset($tieuChi['moc_chuan'])) {
                $insertData['moc_chuan'] = $tieuChi['moc_chuan'];
            } else {
                $insertData['moc_chuan'] = [];
            }
            if (isset($tieuChi['minh_chung'])) {
                $insertData['minh_chung'] = $tieuChi['minh_chung'];
            } else {
                $insertData['minh_chung'] = [];
            }
            TuDanhGiaDraft::updateOrCreate([
                'university_id' => $universityId,
                'role' => $user->role_id,
                'tieu_chuan' => $tieuChuan,
                'tieu_chi' => $tieuChi['id']
            ], $insertData);
        }
        $result = [
            'success' => true,
            'message' => "Lưu thành công"
        ];
        return \response()->json($result);
    }

    public function nop()
    {

    }

}
