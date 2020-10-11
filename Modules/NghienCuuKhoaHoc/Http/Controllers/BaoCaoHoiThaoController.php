<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 05/07/2019
 * Time: 22:42
 */

namespace Modules\NghienCuuKhoaHoc\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\NghienCuuKhoaHoc\Entities\BaoCaoHoiThao;
use Modules\NghienCuuKhoaHoc\Http\Requests\BaoCaoHoiThaoRequest;
use Modules\ThongTinChung\Helpers\TomTat;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BaoCaoHoiThaoController extends Controller
{
    public function index($year, Request $request)
    {
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = $request->get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $this->authorize('index', BaoCaoHoiThao::class);

        $quocTe = BaoCaoHoiThao::where('university_id', $universityId)
            ->where('year', $year)
            ->where('phan_loai_hoi_thao_id', 1)
            ->first();
        $trongNuoc = BaoCaoHoiThao::where('university_id', $universityId)
            ->where('year', $year)
            ->where('phan_loai_hoi_thao_id', 2)
            ->first();
        $capTruong = BaoCaoHoiThao::where('university_id', $universityId)
            ->where('year', $year)
            ->where('phan_loai_hoi_thao_id', 3)
            ->first();

        $tiSo = TomTat::get($universityId, $year, 'ti_so_bai_bao_cb', 0);
        $result = [
            'success' => true,
            'message' => 'Lấy báo cáo hội thảo thành công',
            'data' => [
                'quoc_te' => $quocTe,
                'trong_nuoc' => $trongNuoc,
                'cap_truong' => $capTruong,
                'ti_so_bao_cao' => $tiSo
            ]
        ];
        return response()->json($result, 200);
    }

    public function list($year, Request $request)
    {
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = $request->get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $this->authorize('index', BaoCaoHoiThao::class);
        $tiSo = TomTat::get($universityId, $year, 'ti_so_bai_bao_cb', 0);
        $data = [];
        $i = 5;
        while ($i > 0) {
            $quocTe = BaoCaoHoiThao::where('university_id', $universityId)
                ->where('year', $year)
                ->where('phan_loai_hoi_thao_id', 1)
                ->first();
            $trongNuoc = BaoCaoHoiThao::where('university_id', $universityId)
                ->where('year', $year)
                ->where('phan_loai_hoi_thao_id', 2)
                ->first();
            $capTruong = BaoCaoHoiThao::where('university_id', $universityId)
                ->where('year', $year)
                ->where('phan_loai_hoi_thao_id', 3)
                ->first();
            $data[$year] = [
                'quoc_te' => $quocTe,
                'trong_nuoc' => $trongNuoc,
                'cap_truong' => $capTruong,

            ];
            $year--;
            $i--;
        }
        $responseData = [
            'ti_so_bao_cao' => $tiSo,
            'bao_cao' => $data
        ];

        $result = [
            'success' => true,
            'message' => 'Lấy báo cáo hội thảo thành công',
            'data' => $responseData
        ];
        return response()->json($result, 200);
    }


    public function store($year, BaoCaoHoiThaoRequest $request)
    {

        $user = Auth::user();
        $this->authorize('store', BaoCaoHoiThao::class);
        $inputData = $request->validated();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = $request->get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $data = [];
        $data['university_id'] = $universityId;
        $data['year'] = $year;

        $data['phan_loai_hoi_thao_id'] = 1;
        $data['so_luong'] = $inputData['quoc_te'];
        $quocTe = BaoCaoHoiThao::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $universityId,
                'phan_loai_hoi_thao_id' => 1
            ],
            $data);


        $data['phan_loai_hoi_thao_id'] = 2;
        $data['so_luong'] = $inputData['trong_nuoc'];
        $trongNuoc = BaoCaoHoiThao::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $universityId,
                'phan_loai_hoi_thao_id' => 2
            ],
            $data);

        $data['phan_loai_hoi_thao_id'] = 3;
        $data['so_luong'] = $inputData['cap_truong'];
        $capTruong = BaoCaoHoiThao::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $universityId,
                'phan_loai_hoi_thao_id' => 3
            ],
            $data);
        $tiLe = TomTat::tiSoBaoCaoHoiThao($universityId, $year);
        TomTat::save($universityId, $year, 'ti_so_bai_bao_cb', $tiLe);
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
