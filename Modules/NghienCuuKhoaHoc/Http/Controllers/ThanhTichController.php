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
use Illuminate\Support\Facades\Input;
use Modules\NghienCuuKhoaHoc\Entities\ThanhTich;
use Modules\NghienCuuKhoaHoc\Http\Requests\ThanhTichRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ThanhTichController extends Controller
{
    public function index($year)
    {
        $user = Auth::user();
        $this->authorize('index', ThanhTich::class);

        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $thanhTich = ThanhTich::where('university_id', $universityId)
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
        $this->authorize('store', ThanhTich::class);
        $data = $request->validated();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $data['university_id'] = $universityId;
        $data['year'] = $year;

        $thanhTich = ThanhTich::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $universityId
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
