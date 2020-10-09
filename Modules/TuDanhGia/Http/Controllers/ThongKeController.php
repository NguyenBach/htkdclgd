<?php


namespace Modules\TuDanhGia\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Modules\ThongTinChung\Entities\University;

class ThongKeController extends Controller
{

    public function danhGiaNgoai()
    {
        $user = Auth::user();
        $perPage = Input::get('per-page');
        if (!$perPage || !is_numeric($perPage)) {
            $perPage = 5;
        }
        $universities = University::select(['id', 'name_vi'])->with('danhGiaNgoai')->paginate($perPage);

        $result = [
            'success' => true,
            'message' => "Lấy thông tin thành công",
            'data' => $universities
        ];
        return \response()->json($result);
    }

    public function tuDanhGia()
    {
        $user = Auth::user();
        $perPage = Input::get('per-page');
        if (!$perPage || !is_numeric($perPage)) {
            $perPage = 5;
        }
        $universities = University::select(['id', 'name_vi'])->with('tuDanhGia')->paginate($perPage);

        $result = [
            'success' => true,
            'message' => "Lấy thông tin thành công",
            'data' => $universities
        ];
        return \response()->json($result);
    }

    public function soSanh()
    {
        $user = Auth::user();
        $perPage = Input::get('per-page');
        if (!$perPage || !is_numeric($perPage)) {
            $perPage = 5;
        }
        $universities = University::select(['id', 'name_vi'])
            ->with('danhGiaNgoai')
            ->with('tuDanhGia')
            ->paginate($perPage);

        $result = [
            'success' => true,
            'message' => "Lấy thông tin thành công",
            'data' => $universities
        ];
        return \response()->json($result);
    }
}
