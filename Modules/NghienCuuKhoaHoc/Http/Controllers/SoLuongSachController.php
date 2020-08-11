<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 05/07/2019
 * Time: 22:42
 */

namespace Modules\NghienCuuKhoaHoc\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\NghienCuuKhoaHoc\Entities\SoLuongSach;
use Modules\NghienCuuKhoaHoc\Http\Requests\SoLuongSachRequest;

class SoLuongSachController extends Controller
{
    public function index($year)
    {
        $user = Auth::user();
        $this->authorize('so_luong_sach', SoLuongSach::class);

        $chuyenKhao = SoLuongSach::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('loai_sach_id', 1)
            ->first();
        $giaoTrinh = SoLuongSach::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('loai_sach_id', 2)
            ->first();
        $thamKhao = SoLuongSach::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('loai_sach_id', 3)
            ->first();
        $huongDan = SoLuongSach::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('loai_sach_id', 4)
            ->first();

        $result = [
            'success' => true,
            'message' => 'Lấy số lượng sách thành công',
            'data' => [
                'chuyen_khao' => $chuyenKhao,
                'giao_trinh' => $giaoTrinh,
                'tham_khao' => $thamKhao,
                'huong_dan' => $huongDan
            ]
        ];
        return response()->json($result, 200);
    }


    public function store($year, SoLuongSachRequest $request)
    {

        $user = Auth::user();
        $this->authorize('so_luong_sach', SoLuongSach::class);
        $inputData = $request->validated();
        $data = [];
        $data['university_id'] = $user->university_id;
        $data['year'] = $year;

        $data['loai_sach_id'] = 1;
        $data['so_luong'] = $inputData['chuyen_khao'];
        $chuyenKhao = SoLuongSach::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $user->university_id,
                'loai_sach_id' => 1
            ],
            $data);


        $data['loai_sach_id'] = 2;
        $data['so_luong'] = $inputData['giao_trinh'];
        $giaoTrinh = SoLuongSach::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $user->university_id,
                'loai_sach_id' => 2
            ],
            $data);

        $data['loai_sach_id'] = 3;
        $data['so_luong'] = $inputData['tham_khao'];
        $thamKhao = SoLuongSach::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $user->university_id,
                'loai_sach_id' => 3
            ],
            $data);

        $data['loai_sach_id'] = 4;
        $data['so_luong'] = $inputData['huong_dan'];
        $huongDan = SoLuongSach::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $user->university_id,
                'loai_sach_id' => 4
            ],
            $data);

        $result = [
            'success' => true,
            'message' => 'Update só lượng sách thành công',
            'data' => [
                'chuyen_khao' => $chuyenKhao,
                'giao_trinh' => $giaoTrinh,
                'tham_khao' => $thamKhao,
                'huong_dan' => $huongDan
            ]
        ];
        return response()->json($result, 200);
    }
}