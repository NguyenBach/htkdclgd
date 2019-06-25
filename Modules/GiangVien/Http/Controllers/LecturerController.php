<?php

namespace Modules\GiangVien\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\GiangVien\Entities\Lecturer;
use Modules\GiangVien\Http\Requests\LecturerRequest;

class LecturerController extends Controller
{

    public function index($year)
    {
        $user = Auth::user();
        $this->authorize('lecturer', Lecturer::class);
        $lecturer = Lecturer::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('lecturer_type', 1)
            ->get();
        $researcher = Lecturer::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('lecturer_type', 2)
            ->get();
        $result = [
            'success' => true,
            'message' => 'Lấy giảng viên thành công',
            'data' => [
                'giang_vien' => $lecturer,
                'nghien_cuu_vien' => $researcher
            ]
        ];
        return response()->json($result, 200);
    }


    public function store($year, LecturerRequest $request)
    {
        //
        $user = Auth::user();
        $this->authorize('lecturer', Lecturer::class);
        $data = $request->validated();
        $insertData = [];
        $insertData['university_id'] = $user->university_id;
        $insertData['year'] = $year;
        $lecturer = json_decode($data['giang_vien'], true);
        $insertData['lecturer_type'] = 1; //Giang vien
        $insertData['total_1'] = $lecturer['tong_co_huu'] ?? 0;
        $insertData['percent_doctor_1'] = $lecturer['percent_ts_co_huu'] ?? 0;
        $insertData['total_2'] = $lecturer['tong_thinh_giang'] ?? 0;
        $insertData['percent_doctor_2'] = $lecturer['percent_ts_thinh_giang'] ?? 0;
        $lecturer1 = Lecturer::updateOrCreate(
            [
                'year' => $year,
                'lecturer_type' => 1,
                'university_id' => $user->university_id
            ],
            $insertData);

        $researcher = json_decode($data['nghien_cuu_vien'], true);
        $insertData['lecturer_type'] = 2; //Nghien cuu vien
        $insertData['total_1'] = $researcher['tong_co_huu'] ?? 0;
        $insertData['percent_doctor_1'] = $researcher['percent_ts_co_huu'] ?? 0;
        $insertData['total_2'] = $researcher['tong_thinh_giang'] ?? 0;
        $insertData['percent_doctor_2'] = $researcher['percent_ts_thinh_giang'] ?? 0;

        $lecturer2 = Lecturer::updateOrCreate(
            [
                'year' => $year,
                'lecturer_type' => 2,
                'university_id' => $user->university_id
            ],
            $insertData
        );

        $result = [
            'success' => true,
            'message' => 'Thêm giảng viên thành công',
            'data' => [
                'giang_vien' => $lecturer1,
                'nghien_cuu_vien' => $lecturer2
            ]
        ];
        return \response()->json($result, 200);
    }


}
