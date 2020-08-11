<?php

namespace Modules\GiangVien\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\GiangVien\Entities\OfficerByGender;
use Modules\GiangVien\Http\Requests\OfficerByGenderRequest;

class OfficerByGenderController extends Controller
{

    public function store($year, OfficerByGenderRequest $request)
    {
        //
        $this->authorize('officer_by_gender', OfficerByGender::class);
        $data = $request->validated();
        $user = Auth::user();
        $primary = [
            'university_id' => $user->university_id,
            'year' => $year
        ];

        $officer = OfficerByGender::updateOrCreate($primary, $data);

        $result = [
            'success' => true,
            'message' => 'Thêm cán bộ theo giới tính thành công',
            'data' => [
                'officer_by_gender' => $officer
            ]
        ];
        return response()->json($result, 200);
    }


    public function show($year)
    {
        $this->authorize('officer_by_gender', OfficerByGender::class);
        $user = Auth::user();
        $officer = OfficerByGender::where('year', $year)
            ->where('university_id', $user->university_id)
            ->first();
        $result = [
            'success' => true,
            'message' => 'Lấy cán bộ theo giới tính thành công',
            'data' => [
                'officer_by_gender' => $officer
            ]
        ];
        return response()->json($result, 200);
    }


}
