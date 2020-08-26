<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 03/07/2019
 * Time: 22:15
 */

namespace Modules\NguoiHoc\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Modules\NguoiHoc\Entities\SvThamGiaNCKH;
use Modules\NguoiHoc\Http\Requests\SvThamGiaNCKHRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SvThamGiaNCKHController extends Controller
{
    public function index($year)
    {
        $user = Auth::user();
        $this->authorize('index', SvThamGiaNCKH::class);

        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $svktx = SvThamGiaNCKH::where('university_id', $universityId)
            ->where('year', $year)
            ->first();

        $result = [
            'success' => true,
            'message' => 'Lấy sinh viên tham gia nckh thành công',
            'data' => [
                'sv_tham_gia_nckh' => $svktx
            ]
        ];
        return response()->json($result, 200);
    }


    public function store($year, SvThamGiaNCKHRequest $request)
    {

        $user = Auth::user();
        $this->authorize('store', SvThamGiaNCKH::class);
        $data = $request->validated();

        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $data['university_id'] = $universityId;
        $data['year'] = $year;

        $svKtx = SvThamGiaNCKH::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $universityId
            ],
            $data);

        $result = [
            'success' => true,
            'message' => 'Update sinh viên tham gia nckh thành công',
            'data' => [
                'sv_tham_gia_nckh' => $svKtx
            ]
        ];
        return response()->json($result, 200);
    }
}
