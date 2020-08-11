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
use Modules\NghienCuuKhoaHoc\Entities\CanBoTapChi;
use Modules\NghienCuuKhoaHoc\Http\Requests\CanBoTapChiRequest;

class CanBoTapChiController extends Controller
{
    public function index($year)
    {
        $user = Auth::user();
        $this->authorize('can_bo_tap_chi', CanBoTapChi::class);

        $quocTe = CanBoTapChi::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('phan_loai_tap_chi_id', 1)
            ->first();
        $trongNuoc = CanBoTapChi::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('phan_loai_tap_chi_id', 2)
            ->first();
        $capTruong = CanBoTapChi::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('phan_loai_tap_chi_id', 3)
            ->first();

        $result = [
            'success' => true,
            'message' => 'Lấy cán bộ viết tạp chí thành công',
            'data' => [
                'quoc_te' => $quocTe,
                'trong_nuoc' => $trongNuoc,
                'cap_truong' => $capTruong
            ]
        ];
        return response()->json($result, 200);
    }


    public function store($year, CanBoTapChiRequest $request)
    {

        $user = Auth::user();
        $this->authorize('can_bo_tap_chi', CanBoTapChi::class);
        $inputData = $request->validated();
        $data = [];
        $data['university_id'] = $user->university_id;
        $data['year'] = $year;

        $dataQuocTe = json_decode($inputData['quoc_te'], true);
        $data['phan_loai_tap_chi_id'] = 1;
        $data['tu_1_5'] = $dataQuocTe['tu_1_5'] ?? 0;
        $data['tu_6_10'] = $dataQuocTe['tu_6_10'] ?? 0;
        $data['tu_11_15'] = $dataQuocTe['tu_11_15'] ?? 0;
        $data['tren_15'] = $dataQuocTe['tren_15'] ?? 0;
        $quocTe = CanBoTapChi::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $user->university_id,
                'university_id' => $user->university_id,
                'phan_loai_tap_chi_id' => 1
            ],
            $data);

        $dataTrongNuoc = json_decode($inputData['trong_nuoc'], true);
        $data['phan_loai_tap_chi_id'] = 2;
        $data['tu_1_5'] = $dataTrongNuoc['tu_1_5'] ?? 0;
        $data['tu_6_10'] = $dataTrongNuoc['tu_6_10'] ?? 0;
        $data['tu_11_15'] = $dataTrongNuoc['tu_11_15'] ?? 0;
        $data['tu_11_15'] = $dataTrongNuoc['tu_11_15'] ?? 0;
        $data['tren_15'] = $dataTrongNuoc['tren_15'] ?? 0;
        $trongNuoc = CanBoTapChi::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $user->university_id,
                'phan_loai_tap_chi_id' => 2
            ],
            $data);

        $dataCapTruong = json_decode($inputData['cap_truong'], true);
        $data['phan_loai_tap_chi_id'] = 3;
        $data['tu_1_5'] = $dataCapTruong['tu_1_5'] ?? 0;
        $data['tu_6_10'] = $dataCapTruong['tu_6_10'] ?? 0;
        $data['tu_11_15'] = $dataCapTruong['tu_11_15'] ?? 0;
        $data['tu_11_15'] = $dataCapTruong['tu_11_15'] ?? 0;
        $data['tren_15'] = $dataCapTruong['tren_15'] ?? 0;
        $capTruong = CanBoTapChi::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $user->university_id,
                'phan_loai_tap_chi_id' => 3
            ],
            $data);

        $result = [
            'success' => true,
            'message' => 'Update cán bộ nghiên cứu khoa hoc thành công',
            'data' => [
                'quoc_te' => $quocTe,
                'trong_nuoc' => $trongNuoc,
                'cap_truong' => $capTruong
            ]
        ];
        return response()->json($result, 200);
    }
}