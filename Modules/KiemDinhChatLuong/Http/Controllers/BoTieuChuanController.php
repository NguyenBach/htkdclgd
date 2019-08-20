<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 20/08/2019
 * Time: 21:11
 */

namespace Modules\KiemDinhChatLuong\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\KiemDinhChatLuong\Entities\TieuChuanKiemDinh;
use Modules\KiemDinhChatLuong\Http\Requests\TieuChuanKiemDinhRequest;

class BoTieuChuanController extends Controller
{

    public function index()
    {
        $tieuChuan = TieuChuanKiemDinh::all();
        $result = [
            'success' => true,
            'message' => 'Lấy tiêu chuẩn kiểm định thành công',
            'data' => [
                'bo_tieu_chuan' => $tieuChuan
            ]
        ];
        return response()->json($result);
    }

    public function store(TieuChuanKiemDinhRequest $request)
    {
        $data = $request->validated();
        $tieuChuan = TieuChuanKiemDinh::create($data);
        $result = [
            'success' => true,
            'message' => 'Tạo tiêu chuẩn kiểm định thành công',
            'data' => [
                'bo_tieu_chuan' => $tieuChuan
            ]
        ];
        return response()->json($result);
    }

    public function update()
    {

    }

    public function delete()
    {

    }
}