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
use Modules\NghienCuuKhoaHoc\Entities\CanBoSach;
use Modules\NghienCuuKhoaHoc\Entities\CanBoTapChi;
use Modules\NghienCuuKhoaHoc\Http\Requests\CanBoSachRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CanBoSachController extends Controller
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
        $this->authorize('index', CanBoTapChi::class);

        $chuyenKhao = CanBoSach::where('university_id', $universityId)
            ->where('year', $year)
            ->where('loai_sach_id', 1)
            ->first();
        $giaoTrinh = CanBoSach::where('university_id', $universityId)
            ->where('year', $year)
            ->where('loai_sach_id', 2)
            ->first();
        $thamKhao = CanBoSach::where('university_id', $universityId)
            ->where('year', $year)
            ->where('loai_sach_id', 3)
            ->first();

        $huongDan = CanBoSach::where('university_id', $universityId)
            ->where('year', $year)
            ->where('loai_sach_id', 4)
            ->first();

        $result = [
            'success' => true,
            'message' => 'Lấy cán bộ viết tạp chí thành công',
            'data' => [
                'chuyen_khao' => $chuyenKhao,
                'giao_trinh' => $giaoTrinh,
                'tham_khao' => $thamKhao,
                'huong_dan' => $huongDan,
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
        $this->authorize('index', CanBoTapChi::class);

        $data = [];
        $i = 5;
        while ($i > 0) {
            $chuyenKhao = CanBoSach::where('university_id', $universityId)
                ->where('year', $year)
                ->where('loai_sach_id', 1)
                ->first();
            $giaoTrinh = CanBoSach::where('university_id', $universityId)
                ->where('year', $year)
                ->where('loai_sach_id', 2)
                ->first();
            $thamKhao = CanBoSach::where('university_id', $universityId)
                ->where('year', $year)
                ->where('loai_sach_id', 3)
                ->first();
            $huongDan = CanBoSach::where('university_id', $universityId)
                ->where('year', $year)
                ->where('loai_sach_id', 4)
                ->first();
            $data[$year] = [
                'chuyen_khao' => $chuyenKhao,
                'giao_trinh' => $giaoTrinh,
                'tham_khao' => $thamKhao,
                'huong_dan' => $huongDan,
            ];
            $year--;
            $i--;
        }

        $result = [
            'success' => true,
            'message' => 'Lấy cán bộ viết tạp chí thành công',
            'data' => $data
        ];
        return response()->json($result, 200);
    }


    public function store($year, CanBoSachRequest $request)
    {

        $user = Auth::user();
        $this->authorize('store', CanBoSach::class);
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

        $dataChuyenKhao = json_decode($inputData['chuyen_khao'], true);
        $data['loai_sach_id'] = 1;
        $data['tu_1_3'] = $dataChuyenKhao['tu_1_3'] ?? 0;
        $data['tu_4_6'] = $dataChuyenKhao['tu_4_6'] ?? 0;
        $data['tren_6'] = $dataChuyenKhao['tren_6'] ?? 0;
        $chuyenKhao = CanBoSach::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $universityId,
                'loai_sach_id' => 1
            ],
            $data);

        $dataGiaoTrinh = json_decode($inputData['giao_trinh'], true);
        $data['loai_sach_id'] = 2;
        $data['tu_1_3'] = $dataGiaoTrinh['tu_1_3'] ?? 0;
        $data['tu_4_6'] = $dataGiaoTrinh['tu_4_6'] ?? 0;
        $data['tren_6'] = $dataGiaoTrinh['tren_6'] ?? 0;
        $giaoTrinh = CanBoSach::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $universityId,
                'loai_sach_id' => 2
            ],
            $data);

        $dataThamKhao = json_decode($inputData['tham_khao'], true);
        $data['loai_sach_id'] = 3;
        $data['tu_1_3'] = $dataThamKhao['tu_1_3'] ?? 0;
        $data['tu_4_6'] = $dataThamKhao['tu_4_6'] ?? 0;
        $data['tren_6'] = $dataThamKhao['tren_6'] ?? 0;
        $thamKhao = CanBoSach::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $universityId,
                'loai_sach_id' => 3
            ],
            $data);

        $dataHuongDan = json_decode($inputData['huong_dan'], true);
        $data['loai_sach_id'] = 4;
        $data['tu_1_3'] = $dataHuongDan['tu_1_3'] ?? 0;
        $data['tu_4_6'] = $dataHuongDan['tu_4_6'] ?? 0;
        $data['tren_6'] = $dataHuongDan['tren_6'] ?? 0;
        $huongDan = CanBoSach::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $universityId,
                'loai_sach_id' => 4
            ],
            $data);

        $result = [
            'success' => true,
            'message' => 'Update cán bộ nghiên cứu khoa hoc thành công',
            'data' => [
                'chuyen_khao' => $chuyenKhao,
                'giao_trinh' => $giaoTrinh,
                'tham_khao' => $thamKhao,
                'huong_dan' => $huongDan,
            ]
        ];
        return response()->json($result, 200);
    }
}
