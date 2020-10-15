<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 04/07/2019
 * Time: 23:11
 */

namespace Modules\NguoiHoc\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Modules\NguoiHoc\Entities\CauHoiTotNghiep;
use Modules\NguoiHoc\Entities\TinhTrangSvTotNghiep;
use Modules\NguoiHoc\Http\Requests\TinhTrangSvTotNghiepRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TinhTrangSvTotNghiepController extends Controller
{
    public function index($heHoc, $year)
    {
        if ($heHoc == 'dai-hoc') {
            $heHoc = 1;
        } else {
            if ($heHoc == 'cao-dang') {
                $heHoc = 0;
            } else {
                $result = [
                    'success' => false,
                    'message' => 'Hệ học không tồn tại'
                ];
                return response()->json($result, 404);
            }
        }
        $user = Auth::user();
        $this->authorize('index', TinhTrangSvTotNghiep::class);

        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $tinhTrang = TinhTrangSvTotNghiep::where('he_hoc', $heHoc)
            ->where('year', $year)
            ->where('university_id', $universityId)
            ->with('cauHoi')
            ->get();

        $result = [
            'success' => true,
            'message' => 'Lấy sinh người học tốt nghiệp thành công',
            'data' => [
                'tinh_trang' => $tinhTrang
            ]
        ];
        return response()->json($result, 200);
    }

    public function list($heHoc, $year)
    {
        if ($heHoc == 'dai-hoc') {
            $heHoc = 1;
        } else {
            if ($heHoc == 'cao-dang') {
                $heHoc = 0;
            } else {
                $result = [
                    'success' => false,
                    'message' => 'Hệ học không tồn tại'
                ];
                return response()->json($result, 404);
            }
        }
        $user = Auth::user();
        $this->authorize('index', TinhTrangSvTotNghiep::class);

        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $data = [];
        $i = 5;
        while ($i > 0) {
            $tinhTrang = TinhTrangSvTotNghiep::where('he_hoc', $heHoc)
                ->where('year', $year)
                ->where('university_id', $universityId)
                ->with('cauHoi')
                ->get();
            $data[$year] = [
                'tinh_trang' => $tinhTrang
            ];
            $year--;
            $i--;
        }

        $result = [
            'success' => true,
            'message' => 'Lấy sinh người học tốt nghiệp thành công',
            'data' => $data
        ];
        return response()->json($result, 200);
    }


    public function store($heHoc, $year, TinhTrangSvTotNghiepRequest $request)
    {
        if ($heHoc == 'dai-hoc') {
            $heHoc = 1;
        } else {
            if ($heHoc == 'cao-dang') {
                $heHoc = 0;
            } else {
                $result = [
                    'success' => false,
                    'message' => 'Hệ học không tồn tại'
                ];
                return response()->json($result, 404);
            }
        }
        $user = Auth::user();
        $this->authorize('store', TinhTrangSvTotNghiep::class);
        $data = $request->validated();
        $tinhTrang = json_decode($data['tinh_trang'], true);

        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $insertData = [];
        $insertData['university_id'] = $universityId;
        $insertData['year'] = $year;
        $insertData['he_hoc'] = $heHoc;

        $cauHoi = CauHoiTotNghiep::all();

        foreach ($cauHoi as $item) {
            if (isset($tinhTrang[$item->id])) {
                $insertData['cau_hoi_id'] = $item->id;
                $insertData['tra_loi'] = $tinhTrang[$item->id];
                TinhTrangSvTotNghiep::updateOrCreate(
                    [
                        'year' => $year,
                        'university_id' => $universityId,
                        'he_hoc' => $heHoc,
                        'cau_hoi_id' => $item->id
                    ],
                    $insertData);
            }

        }


        $tinhTrang = TinhTrangSvTotNghiep::where('he_hoc', $heHoc)
            ->where('year', $year)
            ->where('university_id', $universityId)
            ->with('cauHoi')
            ->get();

        $result = [
            'success' => true,
            'message' => 'Update người học tốt nghiệp thành công',
            'data' => [
                'tinh_trang' => $tinhTrang
            ]
        ];
        return response()->json($result, 200);
    }
}
