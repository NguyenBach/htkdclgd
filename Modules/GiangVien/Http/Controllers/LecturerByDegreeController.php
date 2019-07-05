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
use Modules\GiangVien\Http\Requests\LecturerByDegreeRequest;

class LecturerByDegreeController extends Controller
{
    public function index($year)
    {
        $user = Auth::user();
        $this->authorize('lecturer_by_degree', LecturerByDegree::class);
        $bienChe = LecturerByDegree::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('lecturer_type', 1)
            ->first();
        $daiHan = LecturerByDegree::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('lecturer_type', 2)
            ->first();
        $quanLy = LecturerByDegree::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('lecturer_type', 3)
            ->first();
        $trongNuoc = LecturerByDegree::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('lecturer_type', 4)
            ->first();
        $quocTe = LecturerByDegree::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('lecturer_type', 5)
            ->first();
        $result = [
            'success' => true,
            'message' => 'Lấy giảng viên thành công',
            'data' => [
                'bien_che' => $bienChe,
                'dai_han' => $daiHan,
                'quan_ly' => $quanLy,
                'trong_nuoc' => $trongNuoc,
                'quoc_te' => $quocTe
            ]
        ];
        return response()->json($result, 200);
    }


    public function store($year, LecturerByDegreeRequest $request)
    {
        //
        $user = Auth::user();
        $this->authorize('lecturer_by_degree', LecturerByDegree::class);
        $data = $request->validated();
        $insertData = [];
        $insertData['university_id'] = $user->university_id;
        $insertData['year'] = $year;

        $bienChe = json_decode($data['bien_che'], true);
        $insertData['lecturer_type'] = 1; //bien che
        $insertData['professor'] = $bienChe['professor'] ?? 0;
        $insertData['associate_professor'] = $bienChe['associate_professor'] ?? 0;
        $insertData['science_doctor'] = $bienChe['science_doctor'] ?? 0;
        $insertData['doctor'] = $bienChe['doctor'] ?? 0;
        $insertData['master'] = $bienChe['master'] ?? 0;
        $insertData['undergraduate'] = $bienChe['undergraduate'] ?? 0;
        $insertData['college'] = $bienChe['college'] ?? 0;
        $insertData['intermediate'] = $bienChe['intermediate'] ?? 0;
        $insertData['other'] = $bienChe['other'] ?? 0;

        $bienChe = LecturerByDegree::updateOrCreate(
            [
                'year' => $year,
                'lecturer_type' => 1,
                'university_id' => $user->university_id
            ],
            $insertData);

        $daiHan = json_decode($data['dai_han'], true);
        $insertData['lecturer_type'] = 2; //bien che
        $insertData['professor'] = $daiHan['professor'] ?? 0;
        $insertData['associate_professor'] = $daiHan['associate_professor'] ?? 0;
        $insertData['science_doctor'] = $daiHan['science_doctor'] ?? 0;
        $insertData['doctor'] = $daiHan['doctor'] ?? 0;
        $insertData['master'] = $daiHan['master'] ?? 0;
        $insertData['undergraduate'] = $daiHan['undergraduate'] ?? 0;
        $insertData['college'] = $daiHan['college'] ?? 0;
        $insertData['intermediate'] = $daiHan['intermediate'] ?? 0;
        $insertData['other'] = $daiHan['other'] ?? 0;

        $daiHan = LecturerByDegree::updateOrCreate(
            [
                'year' => $year,
                'lecturer_type' => 2,
                'university_id' => $user->university_id
            ],
            $insertData);

        $quanLy = json_decode($data['quan_ly'], true);
        $insertData['lecturer_type'] = 3; //bien che
        $insertData['professor'] = $quanLy['professor'] ?? 0;
        $insertData['associate_professor'] = $quanLy['associate_professor'] ?? 0;
        $insertData['science_doctor'] = $quanLy['science_doctor'] ?? 0;
        $insertData['doctor'] = $quanLy['doctor'] ?? 0;
        $insertData['master'] = $quanLy['master'] ?? 0;
        $insertData['undergraduate'] = $quanLy['undergraduate'] ?? 0;
        $insertData['college'] = $quanLy['college'] ?? 0;
        $insertData['intermediate'] = $quanLy['intermediate'] ?? 0;
        $insertData['other'] = $quanLy['other'] ?? 0;

        $quanLy = LecturerByDegree::updateOrCreate(
            [
                'year' => $year,
                'lecturer_type' => 3,
                'university_id' => $user->university_id
            ],
            $insertData);


        $trongNuoc = json_decode($data['trong_nuoc'], true);
        $insertData['lecturer_type'] = 4; //bien che
        $insertData['professor'] = $trongNuoc['professor'] ?? 0;
        $insertData['associate_professor'] = $trongNuoc['associate_professor'] ?? 0;
        $insertData['science_doctor'] = $trongNuoc['science_doctor'] ?? 0;
        $insertData['doctor'] = $trongNuoc['doctor'] ?? 0;
        $insertData['master'] = $trongNuoc['master'] ?? 0;
        $insertData['undergraduate'] = $trongNuoc['undergraduate'] ?? 0;
        $insertData['college'] = $trongNuoc['college'] ?? 0;
        $insertData['intermediate'] = $trongNuoc['intermediate'] ?? 0;
        $insertData['other'] = $trongNuoc['other'] ?? 0;

        $trongNuoc = LecturerByDegree::updateOrCreate(
            [
                'year' => $year,
                'lecturer_type' => 4,
                'university_id' => $user->university_id
            ],
            $insertData);

        $quocTe = json_decode($data['quoc_te'], true);
        $insertData['lecturer_type'] = 5; //bien che
        $insertData['professor'] = $quocTe['professor'] ?? 0;
        $insertData['associate_professor'] = $quocTe['associate_professor'] ?? 0;
        $insertData['science_doctor'] = $quocTe['science_doctor'] ?? 0;
        $insertData['doctor'] = $quocTe['doctor'] ?? 0;
        $insertData['master'] = $quocTe['master'] ?? 0;
        $insertData['undergraduate'] = $quocTe['undergraduate'] ?? 0;
        $insertData['college'] = $quocTe['college'] ?? 0;
        $insertData['intermediate'] = $quocTe['intermediate'] ?? 0;
        $insertData['other'] = $quocTe['other'] ?? 0;

        $quocTe = LecturerByDegree::updateOrCreate(
            [
                'year' => $year,
                'lecturer_type' => 5,
                'university_id' => $user->university_id
            ],
            $insertData);

        $result = [
            'success' => true,
            'message' => 'Thêm giảng viên thành công',
            'data' => [
                'bien_che' => $bienChe,
                'dai_han' => $daiHan,
                'quan_ly' => $quanLy,
                'trong_nuoc' => $trongNuoc,
                'quoc_te' => $quocTe
            ]
        ];
        return response()->json($result, 200);
    }
}