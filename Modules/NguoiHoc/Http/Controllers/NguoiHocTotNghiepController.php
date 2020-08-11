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
use Modules\NguoiHoc\Entities\NguoiHocTotNghiep;
use Modules\NguoiHoc\Http\Requests\NguoiHocTotNghiepRequest;

class NguoiHocTotNghiepController extends Controller
{
    public function index($year)
    {
        $user = Auth::user();
        $this->authorize('nguoi_hoc_tot_nghiep', NguoiHocTotNghiep::class);

        $nguoiHoc = NguoiHocTotNghiep::where('university_id', $user->university_id)
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
        $this->authorize('nguoi_hoc_tot_nghiep', NguoiHocTotNghiep::class);
        $data = $request->validated();
        $data['university_id'] = $user->university_id;
        $data['year'] = $year;

        $svKtx = NguoiHocTotNghiep::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $user->university_id
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