<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 29/07/2019
 * Time: 23:23
 */

namespace Modules\CoSoVatChat\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Modules\CoSoVatChat\Entities\DienTich;
use Modules\CoSoVatChat\Http\Requests\DienTichRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DienTichController extends Controller
{
    public function index($year)
    {
        $user = Auth::user();
        $this->authorize('index', DienTich::class);

        if (!$user->university_id) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
            $user->university_id = $universityId;
        }

        $tong = DienTich::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('noi_dung', 1)
            ->first();
        $giangDuong = DienTich::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('noi_dung', 2)
            ->first();
        $thuVien = DienTich::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('noi_dung', 3)
            ->first();
        $trungTam = DienTich::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('noi_dung', 4)
            ->first();

        $result = [
            'success' => true,
            'message' => 'Lấy cán bộ hoi thao thành công',
            'data' => [
                'tong' => $tong,
                'giang_duong' => $giangDuong,
                'thu_vien' => $thuVien,
                'trung_tam' => $trungTam,
            ]
        ];
        return response()->json($result, 200);
    }

    public function list($year)
    {
        $user = Auth::user();
        $this->authorize('index', DienTich::class);

        if (!$user->university_id) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
            $user->university_id = $universityId;
        }
        $data = [];
        $i = 5;
        while ($i > 0) {
            $tong = DienTich::where('university_id', $user->university_id)
                ->where('year', $year)
                ->where('noi_dung', 1)
                ->first();
            $giangDuong = DienTich::where('university_id', $user->university_id)
                ->where('year', $year)
                ->where('noi_dung', 2)
                ->first();
            $thuVien = DienTich::where('university_id', $user->university_id)
                ->where('year', $year)
                ->where('noi_dung', 3)
                ->first();
            $trungTam = DienTich::where('university_id', $user->university_id)
                ->where('year', $year)
                ->where('noi_dung', 4)
                ->first();

            $data[$year] = [
                'tong' => $tong,
                'giang_duong' => $giangDuong,
                'thu_vien' => $thuVien,
                'trung_tam' => $trungTam,
            ];

            $year--;
            $i--;
        }

        $result = [
            'success' => true,
            'message' => 'Lấy cán bộ hoi thao thành công',
            'data' => $data
        ];
        return response()->json($result, 200);
    }

    public function store($year, DienTichRequest $request)
    {
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = $request->get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $this->authorize('update', DienTich::class);
        $inputData = $request->validated();
        $data = [];
        $data['university_id'] = $universityId;
        $data['year'] = $year;

        $dataTong = json_decode($inputData['tong'], true);
        $data['noi_dung'] = 1;
        $data['dien_tich'] = $dataTong['dien_tich'] ?? 0;
        $data['hinh_thuc'] = $dataTong['hinh_thuc'] ?? 0;

        $tong = DienTich::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $universityId,
                'noi_dung' => 1
            ],
            $data);

        $dataGiangDuong = json_decode($inputData['giang_duong'], true);
        $data['noi_dung'] = 2;
        $data['dien_tich'] = $dataGiangDuong['dien_tich'] ?? 0;
        $data['hinh_thuc'] = $dataGiangDuong['hinh_thuc'] ?? 0;

        $giangDuong = DienTich::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $universityId,
                'noi_dung' => 2
            ],
            $data);

        $dataThuVien = json_decode($inputData['thu_vien'], true);
        $data['noi_dung'] = 3;
        $data['dien_tich'] = $dataThuVien['dien_tich'] ?? 0;
        $data['hinh_thuc'] = $dataThuVien['hinh_thuc'] ?? 0;

        $capTruong = DienTich::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $universityId,
                'noi_dung' => 3
            ],
            $data);

        $dataTrungTam = json_decode($inputData['trung_tam'], true);
        $data['noi_dung'] = 4;
        $data['dien_tich'] = $dataTrungTam['dien_tich'] ?? 0;
        $data['hinh_thuc'] = $dataTrungTam['hinh_thuc'] ?? 0;

        $trungTam = DienTich::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $universityId,
                'noi_dung' => 4
            ],
            $data);

        $result = [
            'success' => true,
            'message' => 'Update diện tích thành công',
            'data' => [
                'tong' => $tong,
                'giang_duong' => $giangDuong,
                'thu_vien' => $capTruong,
                'trung_tam' => $trungTam
            ]
        ];
        return response()->json($result, 200);
    }
}
