<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 16/08/2019
 * Time: 22:19
 */

namespace Modules\CoSoVatChat\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\CoSoVatChat\Entities\ThuChi;
use Modules\CoSoVatChat\Http\Requests\ThuChiRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ThuChiController extends Controller
{

    public function list($year, Request $request)
    {
        $this->authorize('index', ThuChi::class);
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = $request->get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $thuChi = ThuChi::where('year', $year)
            ->where('university_id', $universityId)
            ->first();
        $result = [
            'success' => true,
            'message' => 'Lấy thu chi thành công',
            'data' => [
                'thu_chi' => $thuChi
            ]
        ];
        return response()->json($result);
    }

    public function update($year, ThuChiRequest $request)
    {
        $this->authorize('update', ThuChi::class);
        $data = $request->validated();
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = $request->get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $thuChi = ThuChi::updateOrCreate([
            'university_id' => $universityId,
            'year' => $year
        ], $data);
        $result = [
            'success' => true,
            'message' => 'Update thu chi thành công',
            'data' => [
                'thu_chi' => $thuChi
            ]
        ];
        return response()->json($result);
    }
}
