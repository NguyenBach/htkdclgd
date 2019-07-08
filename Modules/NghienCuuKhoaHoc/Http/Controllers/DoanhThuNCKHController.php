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
use Modules\NghienCuuKhoaHoc\Entities\DoanhThuNCKH;
use Modules\NghienCuuKhoaHoc\Http\Requests\DoanhThuNCKHRequest;

class DoanhThuNCKHController extends Controller
{
    public function index($year)
    {
        $user = Auth::user();
        $this->authorize('doanh_thu_nckh', DoanhThuNCKH::class);

        $doanhThuNCKH = DoanhThuNCKH::where('university_id', $user->university_id)
            ->where('year', $year)
            ->first();

        $result = [
            'success' => true,
            'message' => 'Lấy doanh thu nghiên cứu khoa học thành công',
            'data' => [
                'doanh_thu_nckh' => $doanhThuNCKH
            ]
        ];
        return response()->json($result, 200);
    }


    public function store($year, DoanhThuNCKHRequest $request)
    {

        $user = Auth::user();
        $this->authorize('doanh_thu_nckh', DoanhThuNCKH::class);
        $data = $request->validated();
        $data['university_id'] = $user->university_id;
        $data['year'] = $year;

        $doanhThuNCKH = DoanhThuNCKH::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $user->university_id
            ],
            $data);

        $result = [
            'success' => true,
            'message' => 'Update doanh thu nghiên cứu khoa hoc thành công',
            'data' => [
                'doanh_thu_nckh' => $doanhThuNCKH
            ]
        ];
        return response()->json($result, 200);
    }
}