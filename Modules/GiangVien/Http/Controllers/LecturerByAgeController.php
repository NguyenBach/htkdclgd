<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 27/06/2019
 * Time: 22:14
 */

namespace Modules\GiangVien\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\GiangVien\Entities\LecturerByAge;
use Modules\GiangVien\Http\Requests\LecturerByAgeRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LecturerByAgeController extends Controller
{
    public function index($year, Request $request)
    {
        $user = Auth::user();
        $this->authorize('index', LecturerByAge::class);

        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = $request->get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $giaoSu = LecturerByAge::where('university_id', $universityId)
            ->where('year', $year)
            ->where('lecturer_degree', 1)
            ->first();
        if (!is_null($giaoSu)) {
            $avgAge = $giaoSu->avg_age;
        } else {
            $avgAge = 0;
        }
        $phoGiaoSu = LecturerByAge::where('university_id', $universityId)
            ->where('year', $year)
            ->where('lecturer_degree', 2)
            ->first();
        $tsKhoaHoc = LecturerByAge::where('university_id', $universityId)
            ->where('year', $year)
            ->where('lecturer_degree', 3)
            ->first();
        $tienSi = LecturerByAge::where('university_id', $universityId)
            ->where('year', $year)
            ->where('lecturer_degree', 4)
            ->first();
        $thacSi = LecturerByAge::where('university_id', $universityId)
            ->where('year', $year)
            ->where('lecturer_degree', 5)
            ->first();
        $daiHoc = LecturerByAge::where('university_id', $universityId)
            ->where('year', $year)
            ->where('lecturer_degree', 6)
            ->first();
        $caoDang = LecturerByAge::where('university_id', $universityId)
            ->where('year', $year)
            ->where('lecturer_degree', 7)
            ->first();
        $trungCap = LecturerByAge::where('university_id', $universityId)
            ->where('year', $year)
            ->where('lecturer_degree', 8)
            ->first();
        $khac = LecturerByAge::where('university_id', $universityId)
            ->where('year', $year)
            ->where('lecturer_degree', 9)
            ->first();
        $result = [
            'success' => true,
            'message' => 'Lấy giảng viên thành công',
            'data' => [
                'giao_su' => $giaoSu,
                'pho_giao_su' => $phoGiaoSu,
                'ts_khoa_hoc' => $tsKhoaHoc,
                'tien_si' => $tienSi,
                'thac_si' => $thacSi,
                'dai_hoc' => $daiHoc,
                'cao_dang' => $caoDang,
                'trung_cap' => $trungCap,
                'khac' => $khac,
                'avg_age' => $avgAge

            ]
        ];
        return response()->json($result, 200);
    }


    public function store($year, LecturerByAgeRequest $request)
    {
        //
        $user = Auth::user();
        $this->authorize('create', LecturerByAge::class);

        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = $request->get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $data = $request->validated();
        $insertData = [];
        $insertData['university_id'] = $universityId;
        $insertData['year'] = $year;

        $giaoSu = json_decode($data['giao_su'], true);
        $insertData['lecturer_degree'] = 1; //bien che
        $insertData['total'] = $giaoSu['total'] ?? 0;
        $insertData['percent'] = $giaoSu['percent'] ?? 0;
        $insertData['lecturer_man'] = $giaoSu['lecturer_man'] ?? 0;
        $insertData['lecturer_woman'] = $giaoSu['lecturer_woman'] ?? 0;
        $insertData['less_30'] = $giaoSu['less_30'] ?? 0;
        $insertData['less_40'] = $giaoSu['less_40'] ?? 0;
        $insertData['less_50'] = $giaoSu['less_50'] ?? 0;
        $insertData['less_60'] = $giaoSu['less_60'] ?? 0;
        $insertData['over_60'] = $giaoSu['over_60'] ?? 0;
        $insertData['avg_age'] = $data['avg_age'] ?? 0;

        $giaoSu = LecturerByAge::updateOrCreate(
            [
                'year' => $year,
                'lecturer_degree' => 1,
                'university_id' => $universityId
            ],
            $insertData);

        $phoGiaoSu = json_decode($data['pho_giao_su'], true);
        $insertData['lecturer_degree'] = 2; //bien che
        $insertData['total'] = $phoGiaoSu['total'] ?? 0;
        $insertData['percent'] = $phoGiaoSu['percent'] ?? 0;
        $insertData['lecturer_man'] = $phoGiaoSu['lecturer_man'] ?? 0;
        $insertData['lecturer_woman'] = $phoGiaoSu['lecturer_woman'] ?? 0;
        $insertData['less_30'] = $phoGiaoSu['less_30'] ?? 0;
        $insertData['less_40'] = $phoGiaoSu['less_40'] ?? 0;
        $insertData['less_50'] = $phoGiaoSu['less_50'] ?? 0;
        $insertData['less_60'] = $phoGiaoSu['less_60'] ?? 0;
        $insertData['over_60'] = $phoGiaoSu['over_60'] ?? 0;

        $phoGiaoSu = LecturerByAge::updateOrCreate(
            [
                'year' => $year,
                'lecturer_degree' => 2,
                'university_id' => $universityId
            ],
            $insertData);

        $tsKhoaHoc = json_decode($data['ts_khoa_hoc'], true);
        $insertData['lecturer_degree'] = 3; //bien che
        $insertData['total'] = $tsKhoaHoc['total'] ?? 0;
        $insertData['percent'] = $tsKhoaHoc['percent'] ?? 0;
        $insertData['lecturer_man'] = $tsKhoaHoc['lecturer_man'] ?? 0;
        $insertData['lecturer_woman'] = $tsKhoaHoc['lecturer_woman'] ?? 0;
        $insertData['less_30'] = $tsKhoaHoc['less_30'] ?? 0;
        $insertData['less_40'] = $tsKhoaHoc['less_40'] ?? 0;
        $insertData['less_50'] = $tsKhoaHoc['less_50'] ?? 0;
        $insertData['less_60'] = $tsKhoaHoc['less_60'] ?? 0;
        $insertData['over_60'] = $tsKhoaHoc['over_60'] ?? 0;

        $tsKhoaHoc = LecturerByAge::updateOrCreate(
            [
                'year' => $year,
                'lecturer_degree' => 3,
                'university_id' => $universityId
            ],
            $insertData);

        $tienSi = json_decode($data['tien_si'], true);
        $insertData['lecturer_degree'] = 4; //bien che
        $insertData['total'] = $tienSi['total'] ?? 0;
        $insertData['percent'] = $tienSi['percent'] ?? 0;
        $insertData['lecturer_man'] = $tienSi['lecturer_man'] ?? 0;
        $insertData['lecturer_woman'] = $tienSi['lecturer_woman'] ?? 0;
        $insertData['less_30'] = $tienSi['less_30'] ?? 0;
        $insertData['less_40'] = $tienSi['less_40'] ?? 0;
        $insertData['less_50'] = $tienSi['less_50'] ?? 0;
        $insertData['less_60'] = $tienSi['less_60'] ?? 0;
        $insertData['over_60'] = $tienSi['over_60'] ?? 0;

        $tienSi = LecturerByAge::updateOrCreate(
            [
                'year' => $year,
                'lecturer_degree' => 4,
                'university_id' => $universityId
            ],
            $insertData);

        $thacSi = json_decode($data['thac_si'], true);
        $insertData['lecturer_degree'] = 5; //bien che
        $insertData['total'] = $thacSi['total'] ?? 0;
        $insertData['percent'] = $thacSi['percent'] ?? 0;
        $insertData['lecturer_man'] = $thacSi['lecturer_man'] ?? 0;
        $insertData['lecturer_woman'] = $thacSi['lecturer_woman'] ?? 0;
        $insertData['less_30'] = $thacSi['less_30'] ?? 0;
        $insertData['less_40'] = $thacSi['less_40'] ?? 0;
        $insertData['less_50'] = $thacSi['less_50'] ?? 0;
        $insertData['less_60'] = $thacSi['less_60'] ?? 0;
        $insertData['over_60'] = $thacSi['over_60'] ?? 0;

        $thacSi = LecturerByAge::updateOrCreate(
            [
                'year' => $year,
                'lecturer_degree' => 5,
                'university_id' => $universityId
            ],
            $insertData);

        $daiHoc = json_decode($data['dai_hoc'], true);
        $insertData['lecturer_degree'] = 6; //bien che
        $insertData['total'] = $daiHoc['total'] ?? 0;
        $insertData['percent'] = $daiHoc['percent'] ?? 0;
        $insertData['lecturer_man'] = $daiHoc['lecturer_man'] ?? 0;
        $insertData['lecturer_woman'] = $daiHoc['lecturer_woman'] ?? 0;
        $insertData['less_30'] = $daiHoc['less_30'] ?? 0;
        $insertData['less_40'] = $daiHoc['less_40'] ?? 0;
        $insertData['less_50'] = $daiHoc['less_50'] ?? 0;
        $insertData['less_60'] = $daiHoc['less_60'] ?? 0;
        $insertData['over_60'] = $daiHoc['over_60'] ?? 0;

        $daiHoc = LecturerByAge::updateOrCreate(
            [
                'year' => $year,
                'lecturer_degree' => 6,
                'university_id' => $universityId
            ],
            $insertData);

        $caoDang = json_decode($data['cao_dang'], true);
        $insertData['lecturer_degree'] = 7; //bien che
        $insertData['total'] = $caoDang['total'] ?? 0;
        $insertData['percent'] = $caoDang['percent'] ?? 0;
        $insertData['lecturer_man'] = $caoDang['lecturer_man'] ?? 0;
        $insertData['lecturer_woman'] = $caoDang['lecturer_woman'] ?? 0;
        $insertData['less_30'] = $caoDang['less_30'] ?? 0;
        $insertData['less_40'] = $caoDang['less_40'] ?? 0;
        $insertData['less_50'] = $caoDang['less_50'] ?? 0;
        $insertData['less_60'] = $caoDang['less_60'] ?? 0;
        $insertData['over_60'] = $caoDang['over_60'] ?? 0;

        $caoDang = LecturerByAge::updateOrCreate(
            [
                'year' => $year,
                'lecturer_degree' => 7,
                'university_id' => $universityId
            ],
            $insertData);

        $trungCap = json_decode($data['trung_cap'], true);
        $insertData['lecturer_degree'] = 8; //bien che
        $insertData['total'] = $trungCap['total'] ?? 0;
        $insertData['percent'] = $trungCap['percent'] ?? 0;
        $insertData['lecturer_man'] = $trungCap['lecturer_man'] ?? 0;
        $insertData['lecturer_woman'] = $trungCap['lecturer_woman'] ?? 0;
        $insertData['less_30'] = $trungCap['less_30'] ?? 0;
        $insertData['less_40'] = $trungCap['less_40'] ?? 0;
        $insertData['less_50'] = $trungCap['less_50'] ?? 0;
        $insertData['less_60'] = $trungCap['less_60'] ?? 0;
        $insertData['over_60'] = $trungCap['over_60'] ?? 0;

        $trungCap = LecturerByAge::updateOrCreate(
            [
                'year' => $year,
                'lecturer_degree' => 8,
                'university_id' => $universityId
            ],
            $insertData);

        $khac = json_decode($data['khac'], true);
        $insertData['lecturer_degree'] = 9; //bien che
        $insertData['total'] = $khac['total'] ?? 0;
        $insertData['percent'] = $khac['percent'] ?? 0;
        $insertData['lecturer_man'] = $khac['lecturer_man'] ?? 0;
        $insertData['lecturer_woman'] = $khac['lecturer_woman'] ?? 0;
        $insertData['less_30'] = $khac['less_30'] ?? 0;
        $insertData['less_40'] = $khac['less_40'] ?? 0;
        $insertData['less_50'] = $khac['less_50'] ?? 0;
        $insertData['less_60'] = $khac['less_60'] ?? 0;
        $insertData['over_60'] = $khac['over_60'] ?? 0;

        $khac = LecturerByAge::updateOrCreate(
            [
                'year' => $year,
                'lecturer_degree' => 9,
                'university_id' => $universityId
            ],
            $insertData);

        $result = [
            'success' => true,
            'message' => 'Update giảng viên thành công',
            'data' => [
                'giao_su' => $giaoSu,
                'pho_giao_su' => $phoGiaoSu,
                'ts_khoa_hoc' => $tsKhoaHoc,
                'tien_si' => $tienSi,
                'thac_si' => $thacSi,
                'dai_hoc' => $daiHoc,
                'cao_dang' => $caoDang,
                'trung_cap' => $trungCap,
                'khac' => $khac
            ]
        ];
        return response()->json($result, 200);
    }
}
