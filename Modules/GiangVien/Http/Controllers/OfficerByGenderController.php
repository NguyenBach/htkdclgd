<?php

namespace Modules\GiangVien\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\GiangVien\Entities\OfficerByGender;
use Modules\GiangVien\Http\Requests\OfficerByGenderRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OfficerByGenderController extends Controller
{

    public function store($year, OfficerByGenderRequest $request)
    {
        //
        $this->authorize('store', OfficerByGender::class);
        $data = $request->validated();
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = $request->get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $primary = [
            'university_id' => $universityId,
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


    public function show($year, Request $request)
    {
        $this->authorize('index', OfficerByGender::class);

        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = $request->get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $officer = OfficerByGender::where('year', $year)
            ->where('university_id', $universityId)
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

    public function list($year, Request $request)
    {
        $this->authorize('index', OfficerByGender::class);

        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = $request->get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $data = [];
        $i = 5;

        while ($i > 0) {
            $officer = OfficerByGender::where('year', $year)
                ->where('university_id', $universityId)
                ->first();

            $data[$year] = [
                'officer_by_gender' => $officer
            ];
            $year--;
            $i--;
        }


        $result = [
            'success' => true,
            'message' => 'Lấy cán bộ theo giới tính thành công',
            'data' => $data
        ];
        return response()->json($result, 200);
    }


}
