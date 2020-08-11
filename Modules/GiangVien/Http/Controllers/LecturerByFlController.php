<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 27/06/2019
 * Time: 22:14
 */

namespace Modules\GiangVien\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\GiangVien\Entities\LecturerByDegree;
use Modules\GiangVien\Entities\LecturerByFl;
use Modules\GiangVien\Http\Requests\LecturerByDegreeRequest;
use Modules\GiangVien\Http\Requests\LecturerByFlRequest;

class LecturerByFlController extends Controller
{
    public function index($year)
    {
        $user = Auth::user();
        $this->authorize('lecturer_by_fl', LecturerByFl::class);
        $luonLuon = LecturerByFl::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('frequency', 1)
            ->first();
        $thuongThuong = LecturerByFl::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('frequency', 2)
            ->first();
        $doiKhi = LecturerByFl::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('frequency', 3)
            ->first();
        $itKhi = LecturerByFl::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('frequency', 4)
            ->first();
        $hiemKhi = LecturerByFl::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('frequency', 5)
            ->first();
        $result = [
            'success' => true,
            'message' => 'Lấy giảng viên thành công',
            'data' => [
                'luon_luon' => $luonLuon,
                'thuong_thuong' => $thuongThuong,
                'doi_khi' => $doiKhi,
                'it_khi' => $itKhi,
                'hiem_khi' => $hiemKhi
            ]
        ];
        return response()->json($result, 200);
    }


    public function store($year, LecturerByFlRequest $request)
    {
        //
        $user = Auth::user();
        $this->authorize('lecturer_by_fl', LecturerByFl::class);
        $data = $request->validated();
        $insertData = [];
        $insertData['university_id'] = $user->university_id;
        $insertData['year'] = $year;

        $luonLuon = json_decode($data['luon_luon'], true);
        $insertData['frequency'] = 1; //bien che
        $insertData['foreign_language'] = $luonLuon['foreign_language'] ?? 0;
        $insertData['information_technology'] = $luonLuon['information_technology'] ?? 0;

        $luonLuon = LecturerByFl::updateOrCreate(
            [
                'year' => $year,
                'frequency' => 1,
                'university_id' => $user->university_id
            ],
            $insertData);

        $luonLuon = json_decode($data['luon_luon'], true);
        $insertData['frequency'] = 1; //bien che
        $insertData['foreign_language'] = $luonLuon['foreign_language'] ?? 0;
        $insertData['information_technology'] = $luonLuon['information_technology'] ?? 0;

        $luonLuon = LecturerByFl::updateOrCreate(
            [
                'year' => $year,
                'frequency' => 1,
                'university_id' => $user->university_id
            ],
            $insertData);

        $thuongThuong = json_decode($data['thuong_thuong'], true);
        $insertData['frequency'] = 2; //bien che
        $insertData['foreign_language'] = $thuongThuong['foreign_language'] ?? 0;
        $insertData['information_technology'] = $thuongThuong['information_technology'] ?? 0;

        $thuongThuong = LecturerByFl::updateOrCreate(
            [
                'year' => $year,
                'frequency' => 2,
                'university_id' => $user->university_id
            ],
            $insertData);

        $doiKhi = json_decode($data['doi_khi'], true);
        $insertData['frequency'] = 3; //bien che
        $insertData['foreign_language'] = $doiKhi['foreign_language'] ?? 0;
        $insertData['information_technology'] = $doiKhi['information_technology'] ?? 0;

        $doiKhi = LecturerByFl::updateOrCreate(
            [
                'year' => $year,
                'frequency' => 3,
                'university_id' => $user->university_id
            ],
            $insertData);

        $itKhi = json_decode($data['it_khi'], true);
        $insertData['frequency'] = 4; //bien che
        $insertData['foreign_language'] = $itKhi['foreign_language'] ?? 0;
        $insertData['information_technology'] = $itKhi['information_technology'] ?? 0;

        $itKhi = LecturerByFl::updateOrCreate(
            [
                'year' => $year,
                'frequency' => 4,
                'university_id' => $user->university_id
            ],
            $insertData);

        $hiemKhi = json_decode($data['hiem_khi'], true);
        $insertData['frequency'] = 5; //bien che
        $insertData['foreign_language'] = $hiemKhi['foreign_language'] ?? 0;
        $insertData['information_technology'] = $hiemKhi['information_technology'] ?? 0;

        $hiemKhi = LecturerByFl::updateOrCreate(
            [
                'year' => $year,
                'frequency' => 5,
                'university_id' => $user->university_id
            ],
            $insertData);


        $result = [
            'success' => true,
            'message' => 'Thêm giảng viên thành công',
            'data' => [
                'luon_luon' => $luonLuon,
                'thuong_thuong' => $thuongThuong,
                'doi_khi' => $doiKhi,
                'it_khi' => $itKhi,
                'hiem_khi' => $hiemKhi
            ]
        ];
        return response()->json($result, 200);
    }
}