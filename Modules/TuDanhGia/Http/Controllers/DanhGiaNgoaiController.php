<?php

namespace Modules\TuDanhGia\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Modules\ThongTinChung\Entities\University;
use Modules\TuDanhGia\Entities\DanhGiaNgoai;
use Modules\TuDanhGia\Entities\DanhGiaNgoaiDraft;
use Modules\TuDanhGia\Entities\SubmitHistory;
use Modules\TuDanhGia\Entities\TuDanhGia;
use Modules\TuDanhGia\Entities\TuDanhGiaDraft;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DanhGiaNgoaiController extends Controller
{

    public function index($tieuChuan)
    {
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $danhGiaNgoai = DanhGiaNgoaiDraft::where('university_id', $universityId)
            ->where('tieu_chuan', $tieuChuan)
            ->get();

        $result = [
            'success' => true,
            'message' => "Lấy thông tin thành công",
            'data' => $danhGiaNgoai
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
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $insertData = [
            'university_id' => $universityId,
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
            DanhGiaNgoaiDraft::updateOrCreate([
                'university_id' => $universityId,
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

    public function submit(Request $request)
    {
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = $request->get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $draft = DanhGiaNgoaiDraft::where('university_id', $universityId)
            ->get();
        DanhGiaNgoai::where('university_id', $universityId)
            ->delete();
        foreach ($draft as $item) {
            DanhGiaNgoai::updateOrCreate([
                'university_id' => $universityId,
                'tieu_chuan' => $item->tieu_chuan,
                'tieu_chi' => $item->tieu_chi
            ], [
                'diem' => $item->diem_thong_nhat,
                'submit_at' => date('Y-m-d H:i:s')
            ]);
        }
        SubmitHistory::create([
            'university_id' => $universityId,
            'user_id' => $user->id,
            'submit_at' => date('Y-m-d H:i:s'),
            'data' => []
        ]);
        $result = [
            'success' => true,
            'message' => "Lưu thành công"
        ];
        return \response()->json($result);
    }

    public function submitHistory()
    {
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $history = SubmitHistory::where('university_id', $universityId)
            ->orderBy('submit_at', 'desc')
            ->with('user')->get();
        $result = [
            'success' => true,
            'message' => "Lấy dữ liệu thành công",
            'data' => [
                'history' => $history
            ]
        ];
        return \response()->json($result);
    }

    public function lastSubmit()
    {
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $history = SubmitHistory::where('university_id', $universityId)->orderBy('submit_at', 'desc')->with('user')->first();
        $result = [
            'success' => true,
            'message' => "Lấy dữ liệu thành công",
            'data' => [
                'history' => $history
            ]
        ];
        return \response()->json($result);
    }

}
