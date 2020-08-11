<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 29/07/2019
 * Time: 22:45
 */

namespace Modules\NghienCuuKhoaHoc\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\NghienCuuKhoaHoc\Entities\ThanhTich;
use Modules\NghienCuuKhoaHoc\Http\Requests\ThanhTichRequest;

class ThanhTichController extends Controller
{
    public function index($year)
    {
        $user = Auth::user();
        $this->authorize('thanh_tich_nckh', ThanhTich::class);

        $thanhTich = ThanhTich::where('university_id', $user->university_id)
            ->where('year', $year)
            ->first();

        $result = [
            'success' => true,
            'message' => 'Lấy thành tích nckh thành công',
            'data' => [
                'thanh_tich_nckh' => $thanhTich
            ]
        ];
        return response()->json($result, 200);
    }


    public function store($year, ThanhTichRequest $request)
    {

        $user = Auth::user();
        $this->authorize('thanh_tich_nckh', ThanhTich::class);
        $data = $request->validated();
        $data['university_id'] = $user->university_id;
        $data['year'] = $year;

        $thanhTich = ThanhTich::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $user->university_id
            ],
            $data);

        $result = [
            'success' => true,
            'message' => 'Update thành tích nckh thành công',
            'data' => [
                'thanh_tich_nckh' => $thanhTich
            ]
        ];
        return response()->json($result, 200);
    }
}