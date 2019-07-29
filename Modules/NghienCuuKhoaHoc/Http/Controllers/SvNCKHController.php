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
use Modules\NghienCuuKhoaHoc\Entities\SvNCKH;
use Modules\NghienCuuKhoaHoc\Http\Requests\SvNCKHRequest;

class SvNCKHController extends Controller
{
    public function index($year)
    {
        $user = Auth::user();
        $this->authorize('sv_nckh', SvNCKH::class);

        $nhaNuoc = SvNCKH::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('cap_de_tai_id', 1)
            ->first();
        $capBo = SvNCKH::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('cap_de_tai_id', 2)
            ->first();
        $capTruong = SvNCKH::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('cap_de_tai_id', 3)
            ->first();

        $result = [
            'success' => true,
            'message' => 'Lấy sinh viên nghiên cứu khoa học thành công',
            'data' => [
                'nha_nuoc' => $nhaNuoc,
                'cap_bo' => $capBo,
                'cap_truong' => $capTruong
            ]
        ];
        return response()->json($result, 200);
    }


    public function store($year, SvNCKHRequest $request)
    {

        $user = Auth::user();
        $this->authorize('sv_nckh', SvNCKH::class);
        $inputData = $request->validated();
        $data = [];
        $data['university_id'] = $user->university_id;
        $data['year'] = $year;

        $dataNhaNuoc = json_decode($inputData['nha_nuoc'], true);
        $data['cap_de_tai_id'] = 1;
        $data['tu_1_3'] = $dataNhaNuoc['tu_1_3'] ?? 0;
        $data['tu_4_6'] = $dataNhaNuoc['tu_4_6'] ?? 0;
        $data['tren_6'] = $dataNhaNuoc['tren_6'] ?? 0;
        $nhaNuoc = SvNCKH::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $user->university_id,
                'cap_de_tai_id' => 1
            ],
            $data);

        $dataCapBo = json_decode($inputData['cap_bo'], true);
        $data['cap_de_tai_id'] = 2;
        $data['tu_1_3'] = $dataCapBo['tu_1_3'] ?? 0;
        $data['tu_4_6'] = $dataCapBo['tu_4_6'] ?? 0;
        $data['tren_6'] = $dataCapBo['tren_6'] ?? 0;

        $capBo = SvNCKH::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $user->university_id,
                'cap_de_tai_id' => 2
            ],
            $data);

        $dataCapTruong = json_decode($inputData['cap_truong'], true);
        $data['cap_de_tai_id'] = 3;
        $data['tu_1_3'] = $dataCapTruong['tu_1_3'] ?? 0;
        $data['tu_4_6'] = $dataCapTruong['tu_4_6'] ?? 0;
        $data['tren_6'] = $dataCapTruong['tren_6'] ?? 0;

        $capTruong = SvNCKH::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $user->university_id,
                'cap_de_tai_id' => 3
            ],
            $data);

        $result = [
            'success' => true,
            'message' => 'Update sinh viên nghiên cứu khoa hoc thành công',
            'data' => [
                'nha_nuoc' => $nhaNuoc,
                'cap_bo' => $capBo,
                'cap_truong' => $capTruong
            ]
        ];
        return response()->json($result, 200);
    }
}