<?php

namespace Modules\TuDanhGia\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\TuDanhGia\Entities\BaoCaoTuDanhGia;
use Modules\TuDanhGia\Http\Requests\BaoCaoTuDanhGiaRequest;

class BaoCaoTuDanhGiaController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $baoCao = BaoCaoTuDanhGia::where('university_id', $user->university_id)
            ->orderBy('created_at', 'desc')
            ->get();

        $response = [
            'success' => true,
            'message' => "Lấy báo cáo tự đánh giá thành công",
            'data' => $baoCao
        ];
        return \response()->json($response);
    }

    public function store(BaoCaoTuDanhGiaRequest $request)
    {
        $user = Auth::user();
        $file = $request->file('bao_cao');
        $fileMimeType = $file->getClientMimeType();
        if (!in_array($fileMimeType, [
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ])) {
            $data = [
                'success' => false,
                'message' => 'File phải là file doc hoặc docx'
            ];
            return \response()->json($data, 400);
        }
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = "bao-cao-tu-danh-gia/{$user->university->short_name_vi}";
        $filePath = $file->storeAs($path, $this->clean($filename), ['disk']);
        $data['filename'] = $file->getClientOriginalName();
        $data['university_id'] = $user->university_id;
        $data['created_by'] = $user->id;
        $data['file_path'] = $filePath;
        BaoCaoTuDanhGia::create($data);
        return \response()->json([
            'success' => true,
            'message' => "Tải lên báo cáo tự đánh giá thành công"
        ]);
    }

    public function comment(BaoCaoTuDanhGia $baoCao, Request $request)
    {
        $user = Auth::user();
        $file = $request->file('nhan_xet');
        $fileMimeType = $file->getClientMimeType();
        if (!in_array($fileMimeType, [
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ])) {
            $data = [
                'success' => false,
                'message' => 'File phải là file doc hoặc docx'
            ];
            return \response()->json($data, 400);
        }
        $filename = time() . '_nhan_xet_' . $file->getClientOriginalName();
        $path = "bao-cao-tu-danh-gia/{$baoCao->university->short_name_vi}";
        $filePath = $file->storeAs($path, $this->clean($filename), ['disk']);
        $baoCao->file_comment_name = $file->getClientOriginalName();
        $baoCao->commented_by = $user->id;
        $baoCao->file_comment = $filePath;
        $baoCao->save();
        return \response()->json([
            'success' => true,
            'message' => "Tải lên báo cáo tự đánh giá thành công"
        ]);
    }

    private function clean($string)
    {
        $string = str_replace(' ', '-', $string);
        $string = preg_replace('/[^A-Za-z0-9\-._]/', '', $string);
        return preg_replace('/-+/', '-', $string);
    }
}
