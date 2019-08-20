<?php

namespace Modules\KiemDinhChatLuong\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\KiemDinhChatLuong\Entities\KiemDinhChatLuong;
use Modules\KiemDinhChatLuong\Http\Requests\KiemDinhChatLuongRequest;

class KiemDinhChatLuongController extends Controller
{

    public function index()
    {
        $this->authorize('kiem_dinh_chat_luong', KiemDinhChatLuong::class);
        $user = Auth::user();
        $kiemDinh = KiemDinhChatLuong::where('university_id', $user->university_id)
            ->with('doiTuongKiemDinh')
            ->with('toChucKiemDinh')
            ->with('tieuChuanKiemDinh')
            ->get();
        $result = [
            'success' => true,
            'message' => "Lấy kiểm định chất lượng thành công ",
            'data' => [
                'kiem_dinh' => $kiemDinh
            ]
        ];
        return \response()->json($result);
    }


    public function store(KiemDinhChatLuongRequest $request)
    {
        //
        $this->authorize('kiem_dinh_chat_luong', KiemDinhChatLuong::class);
        $user = Auth::user();
        $data = $request->validated();
        $data['university_id'] = $user->university_id;
        $kiemDinh = KiemDinhChatLuong::create($data);
        $result = [
            'success' => true,
            'message' => "create kiểm định chất lượng thành công ",
            'data' => [
                'kiem_dinh' => $kiemDinh
            ]
        ];
        return \response()->json($result);

    }


    public function update(KiemDinhChatLuongRequest $request, KiemDinhChatLuong $model)
    {
        //
        $this->authorize('kiem_dinh_chat_luong', KiemDinhChatLuong::class);
        $data = $request->validated();
        $model->update($data);
        $model->refresh();
        $result = [
            'success' => true,
            'message' => "update kiểm định chất lượng thành công ",
            'data' => [
                'kiem_dinh' => $model
            ]
        ];
        return \response()->json($result);
    }


    public function destroy(KiemDinhChatLuong $model)
    {
        //
        $this->authorize('kiem_dinh_chat_luong', $model);
        $model->delete();
        $result = [
            'success' => true,
            'message' => "Xóa kiểm định chất lượng thành công ",
        ];
        return \response()->json($result);
    }
}
