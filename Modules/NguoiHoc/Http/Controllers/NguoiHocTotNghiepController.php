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
use Modules\NguoiHoc\Entities\NguoiHocTotNghiep;
use Modules\NguoiHoc\Http\Requests\NguoiHocTotNghiepRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NguoiHocTotNghiepController extends Controller
{
    public function index($year)
    {
        $user = Auth::user();
        $this->authorize('index', NguoiHocTotNghiep::class);

        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $nguoiHoc = NguoiHocTotNghiep::where('university_id', $universityId)
            ->where('year', $year)
            ->first();

        $result = [
            'success' => true,
            'message' => 'Lấy sinh người học tốt nghiệp thành công',
            'data' => [
                'nguoi_hoc_tot_nghiep' => $nguoiHoc
            ]
        ];
        return response()->json($result, 200);
    }


    public function store($year, NguoiHocTotNghiepRequest $request)
    {

        $user = Auth::user();
        $this->authorize('store', NguoiHocTotNghiep::class);
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

        $svKtx = NguoiHocTotNghiep::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $universityId
            ],
            $data);

        $result = [
            'success' => true,
            'message' => 'Update sinh người học tốt nghiệp thành công',
            'data' => [
                'nguoi_hoc_tot_nghiep' => $svKtx
            ]
        ];
        return response()->json($result, 200);
    }
}
