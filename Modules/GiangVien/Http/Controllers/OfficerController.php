<?php

namespace Modules\GiangVien\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\GiangVien\Entities\Officer;
use Modules\GiangVien\Http\Requests\OfficerRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OfficerController extends Controller
{

    public function store($year, OfficerRequest $request)
    {
        //
        $this->authorize('update', Officer::class);
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


    public function show($year, Request $request)
    {
        $this->authorize('index', Officer::class);
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = $request->get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $officer = Officer::where('year', $year)
            ->where('university_id', $universityId)
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

    public function list($year, Request $request)
    {
        $this->authorize('index', Officer::class);
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
            $officer = Officer::where('year', $year)
                ->where('university_id', $universityId)
                ->first();
            $data[$year] = [
                'officer' => $officer
            ];
            $year--;
            $i--;
        }

        $result = [
            'success' => true,
            'message' => 'Lấy cán bộ thành công',
            'data' => $data
        ];
        return response()->json($result, 200);
    }

}
