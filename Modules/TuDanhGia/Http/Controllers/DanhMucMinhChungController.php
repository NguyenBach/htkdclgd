<?php

namespace Modules\TuDanhGia\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\TuDanhGia\Entities\DanhMucMinhChung;
use Modules\TuDanhGia\Http\Requests\DanhMucMinhChungRequest;

class DanhMucMinhChungController extends Controller
{


    public function index()
    {
        $user = Auth::user();
        $danhMuc = DanhMucMinhChung::where('university_id', $user->university_id)
            ->orderBy('created_at', 'desc')
            ->with('updatedBy')
            ->get();
        $result = [
            'success' => true,
            'message' => 'Lấy danh muc minh chứng thành công',
            'data' => [
                'danh_muc_minh_chung' => $danhMuc
            ]
        ];
        return response()->json($result, 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     */
    public function store(DanhMucMinhChungRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();
        $file = $request->file('file');
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
        $path = "danh-muc-minh-chung/{$user->username}";
        $filePath = $file->storeAs($path, $this->clean($filename), ['disk']);
        $data['filename'] = $file->getClientOriginalName();
        $data['university_id'] = $user->university_id;
        $data['updated_by'] = $user->id;
        $data['file_url'] = $filePath;
        $data['online_folder_url'] = $data['link'];
        $data['last_change'] = date('Y-m-d H:i:s');
        DanhMucMinhChung::create($data);
        return \response()->json([
            'success' => true,
            'message' => "Tải lên danh mục minh chứng thành công"
        ]);
    }

    private function clean($string)
    {
        $string = str_replace(' ', '-', $string);
        $string = preg_replace('/[^A-Za-z0-9\-._]/', '', $string);
        return preg_replace('/-+/', '-', $string);
    }
}
