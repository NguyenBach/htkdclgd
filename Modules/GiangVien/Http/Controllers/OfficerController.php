<?php

namespace Modules\GiangVien\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\GiangVien\Entities\Officer;
use Modules\GiangVien\Http\Requests\OfficerRequest;

class OfficerController extends Controller
{

    public function store($year, OfficerRequest $request)
    {
        //
        $this->authorize('officer', Officer::class);
        $data = $request->validated();
        $user = Auth::user();
        $primary = [
            'university_id' => $user->university_id,
            'year' => $year
        ];

        $officer = Officer::updateOrCreate($primary, $data);

        $result = [
            'success' => true,
            'message' => 'Thêm cán bộ thành công',
            'data' => [
                'officer' => $officer
            ]
        ];
        return response()->json($result, 200);
    }


    public function show($year)
    {
        $this->authorize('officer', Officer::class);
        $user = Auth::user();
        $officer = Officer::where('year', $year)
            ->where('university_id', $user->university_id)
            ->first();
        $result = [
            'success' => true,
            'message' => 'Lấy cán bộ thành công',
            'data' => [
                'officer' => $officer
            ]
        ];
        return response()->json($result, 200);
    }

}
