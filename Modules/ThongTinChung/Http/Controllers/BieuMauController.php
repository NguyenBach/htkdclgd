<?php

namespace Modules\ThongTinChung\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\ThongTinChung\Entities\BieuMau;
use Modules\ThongTinChung\Http\Requests\BieuMauRequest;

class BieuMauController extends Controller
{

    public function index()
    {
        $bieuMau = BieuMau::paginate(20);
        return \response()->json($bieuMau);
    }


    public function store(BieuMauRequest $request)
    {
        $data = $request->validated();
        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = "bieu-mau";
        $filePath = $file->storeAs($path, $this->clean($filename), ['disk']);
        $data['file_path'] = $filePath;
        $data['file_name'] = $file->getClientOriginalName();
        $data['created_by'] = Auth::user()->id;
        BieuMau::create($data);
        return \response()->json([
            'success' => true,
            'message' => "Tải lên biểu mẫu thành công"
        ]);
    }


    public function destroy(BieuMau $model)
    {
        $model->delete();
        return \response()->json([
            'success' => true,
            'message' => "Xoa biểu mẫu thành công"
        ]);
    }

    private function clean($string)
    {
        $string = str_replace(' ', '-', $string);
        $string = preg_replace('/[^A-Za-z0-9\-._]/', '', $string);
        return preg_replace('/-+/', '-', $string);
    }
}
