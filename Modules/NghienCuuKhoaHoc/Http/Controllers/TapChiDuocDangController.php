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
use Modules\NghienCuuKhoaHoc\Entities\TapChiDuocDang;
use Modules\NghienCuuKhoaHoc\Http\Requests\TapChiDuocDangRequest;

class TapChiDuocDangController extends Controller
{
    public function index($year)
    {
        $user = Auth::user();
        $this->authorize('tap_chi_duoc_dang', TapChiDuocDang::class);

        $isi = TapChiDuocDang::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('phan_loai_tap_chi_id', 1)
            ->where('danh_muc', 'isi')
            ->first();

        $scopus = TapChiDuocDang::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('phan_loai_tap_chi_id', 1)
            ->where('danh_muc', 'scopus')
            ->first();
        $khac = TapChiDuocDang::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('phan_loai_tap_chi_id', 1)
            ->where('danh_muc', 'khac')
            ->first();
        $trongNuoc = TapChiDuocDang::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('phan_loai_tap_chi_id', 2)
            ->first();

        $capTruong = TapChiDuocDang::where('university_id', $user->university_id)
            ->where('year', $year)
            ->where('phan_loai_tap_chi_id', 3)
            ->first();


        $result = [
            'success' => true,
            'message' => 'Lấy tap chí được đăng thành công',
            'data' => [
                'isi' => $isi,
                'scopus' => $scopus,
                'khac' => $khac,
                'trong_nuoc' => $trongNuoc,
                'cap_truong' => $capTruong
            ]
        ];
        return response()->json($result, 200);
    }


    public function store($year, TapChiDuocDangRequest $request)
    {

        $user = Auth::user();
        $this->authorize('tap_chi_duoc_dang', TapChiDuocDang::class);
        $inputData = $request->validated();
        $data = [];
        $data['university_id'] = $user->university_id;
        $data['year'] = $year;

        $data['phan_loai_tap_chi_id'] = 1;
        $data['danh_muc'] = 'isi';
        $data['so_luong'] = $inputData['isi'];
        $isi = TapChiDuocDang::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $user->university_id,
                'phan_loai_tap_chi_id' => 1,
                'danh_muc' => 'isi'
            ],
            $data);


        $data['phan_loai_tap_chi_id'] = 1;
        $data['danh_muc'] = 'scopus';
        $data['so_luong'] = $inputData['scopus'];
        $scopus = TapChiDuocDang::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $user->university_id,
                'phan_loai_tap_chi_id' => 1,
                'danh_muc' => 'scopus'
            ],
            $data);

        $data['phan_loai_tap_chi_id'] = 1;
        $data['danh_muc'] = 'khac';
        $data['so_luong'] = $inputData['khac'];
        $khac = TapChiDuocDang::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $user->university_id,
                'phan_loai_tap_chi_id' => 1,
                'danh_muc' => 'khac'
            ],
            $data);

        $data['phan_loai_tap_chi_id'] = 2;
        $data['so_luong'] = $inputData['trong_nuoc'];
        $trongNuoc = TapChiDuocDang::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $user->university_id,
                'phan_loai_tap_chi_id' => 2
            ],
            $data);

        $data['phan_loai_tap_chi_id'] = 3;
        $data['so_luong'] = $inputData['cap_truong'];
        $capTruong = TapChiDuocDang::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $user->university_id,
                'phan_loai_tap_chi_id' => 3
            ],
            $data);

        $result = [
            'success' => true,
            'message' => 'update tap chí được đăng thành công',
            'data' => [
                'isi' => $isi,
                'scopus' => $scopus,
                'khac' => $khac,
                'trong_nuoc' => $trongNuoc,
                'cap_truong' => $capTruong
            ]
        ];
        return response()->json($result, 200);
    }
}