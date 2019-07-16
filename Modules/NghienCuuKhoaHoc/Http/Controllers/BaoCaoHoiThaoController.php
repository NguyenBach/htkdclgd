<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 05/07/2019
 * Time: 22:42
 */

namespace Modules\NghienCuuKhoaHoc\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\NghienCuuKhoaHoc\Entities\BaoCaoHoiThao;
use Modules\NghienCuuKhoaHoc\Http\Requests\BaoCaoHoiThaoRequest;

class BaoCaoHoiThaoController extends Controller
{
    public function index($year)
    {
        $user = Auth::user();
        $this->authorize('bao_cao_hoi_thao', BaoCaoHoiThao::class);

        $quocTe = BaoCaoHoiThao::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('phan_loai_hoi_thao_id', 1)
            ->first();
        $trongNuoc = BaoCaoHoiThao::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('phan_loai_hoi_thao_id', 2)
            ->first();
        $capTruong = BaoCaoHoiThao::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('phan_loai_hoi_thao_id', 3)
            ->first();


        $result = [
            'success' => true,
            'message' => 'Lấy báo cáo hội thảo thành công',
            'data' => [
                'quoc_te' => $quocTe,
                'trong_nuoc' => $trongNuoc,
                'cap_truong' => $capTruong,

            ]
        ];
        return response()->json($result, 200);
    }


    public function store($year, BaoCaoHoiThaoRequest $request)
    {

        $user = Auth::user();
        $this->authorize('bao_cao_hoi_thao', BaoCaoHoiThao::class);
        $inputData = $request->validated();
        $data = [];
        $data['university_id'] = $user->university_id;
        $data['year'] = $year;

        $data['phan_loai_hoi_thao_id'] = 1;
        $data['so_luong'] = $inputData['quoc_te'];
        $quocTe = BaoCaoHoiThao::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $user->university_id,
                'phan_loai_hoi_thao_id' => 1
            ],
            $data);


        $data['phan_loai_hoi_thao_id'] = 2;
        $data['so_luong'] = $inputData['trong_nuoc'];
        $trongNuoc = BaoCaoHoiThao::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $user->university_id,
                'phan_loai_hoi_thao_id' => 2
            ],
            $data);

        $data['phan_loai_hoi_thao_id'] = 3;
        $data['so_luong'] = $inputData['cap_truong'];
        $capTruong = BaoCaoHoiThao::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $user->university_id,
                'phan_loai_hoi_thao_id' => 3
            ],
            $data);

        $result = [
            'success' => true,
            'message' => 'Update báo cáo hội thảo thành công',
            'data' => [
                'quoc_te' => $quocTe,
                'trong_nuoc' => $trongNuoc,
                'cap_truong' => $capTruong,
            ]
        ];
        return response()->json($result, 200);
    }
}