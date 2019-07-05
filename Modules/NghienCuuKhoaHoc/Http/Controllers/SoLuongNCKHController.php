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
use Modules\NghienCuuKhoaHoc\Entities\SoLuongNCKH;
use Modules\NghienCuuKhoaHoc\Http\Requests\SoLuongNCKHRequest;

class SoLuongNCKHController extends Controller
{
    public function index($year)
    {
        $user = Auth::user();
        $this->authorize('so_luong_nckh', SoLuongNCKH::class);

        $soLuongNCKH = SoLuongNCKH::where('university_id', $user->university_id)
            ->where('year', $year)
            ->first();

        $result = [
            'success' => true,
            'message' => 'Lấy số lượng nghiên cứu khoa học thành công',
            'data' => [
                'so_luong_nckh' => $soLuongNCKH
            ]
        ];
        return response()->json($result, 200);
    }


    public function store($year, SoLuongNCKHRequest $request)
    {

        $user = Auth::user();
        $this->authorize('so_luong_nckh', SoLuongNCKH::class);
        $data = $request->validated();
        $data['university_id'] = $user->university_id;
        $data['year'] = $year;

        $soLuongNCKH = SoLuongNCKH::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $user->university_id
            ],
            $data);

        $result = [
            'success' => true,
            'message' => 'Update số lượng nghiên cứu khoa hoc thành công',
            'data' => [
                'so_luong_nckh' => $soLuongNCKH
            ]
        ];
        return response()->json($result, 200);
    }
}