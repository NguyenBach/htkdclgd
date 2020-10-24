<?php

namespace Modules\TuDanhGia\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Modules\TuDanhGia\Entities\DanhMucMinhChung;
use Modules\TuDanhGia\Http\Requests\DanhMucMinhChungRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DanhMucMinhChungController extends Controller
{


    public function index()
    {
        $user = Auth::user();

        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $danhMuc = DanhMucMinhChung::where('university_id', $universityId)
            ->orderBy('created_at', 'desc')
            ->with('updatedBy')
            ->paginate(20);
        $result = [
            'success' => true,
            'message' => 'Lấy danh muc minh chứng thành công',
            'data' => $danhMuc
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
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/pdf',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.oasis.opendocument.spreadsheet',
            'application/vnd.oasis.opendocument.text'
        ])) {
            $data = [
                'success' => false,
                'message' => 'File phải là file doc,docx,xlsx,xls,pdf'
            ];
            return \response()->json($data, 400);
        }
        echo 1;
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = "danh-muc-minh-chung/{$user->university->short_name_vi}";
        $filePath = $file->storeAs($path, $this->clean($filename), ['disk']);
        $data['filename'] = $file->getClientOriginalName();
        $data['university_id'] = $user->university_id;
        $data['updated_by'] = $user->id;
        $data['file_url'] = url(Storage::url($filePath));
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
