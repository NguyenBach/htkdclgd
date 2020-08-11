<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 20/08/2019
 * Time: 21:22
 */

namespace Modules\KiemDinhChatLuong\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\KiemDinhChatLuong\Entities\ToChucKiemDinh;
use Modules\KiemDinhChatLuong\Http\Requests\ToChucKiemDinhRequest;

class ToChucKiemDinhController extends Controller
{
    public function index()
    {
        $tieuChuan = ToChucKiemDinh::all();
        $result = [
            'success' => true,
            'message' => 'Lấy tổ chức kiểm định thành công',
            'data' => [
                'to_chuc' => $tieuChuan
            ]
        ];
        return response()->json($result);
    }

    public function store(ToChucKiemDinhRequest $request)
    {
        $data = $request->validated();
        $tieuChuan = ToChucKiemDinh::create($data);
        $result = [
            'success' => true,
            'message' => 'Tạo tổ chức kiểm định thành công',
            'data' => [
                'to_chuc' => $tieuChuan
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