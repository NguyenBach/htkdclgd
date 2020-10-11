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
use Illuminate\Support\Facades\Input;
use Modules\NghienCuuKhoaHoc\Entities\SoLuongNCKH;
use Modules\NghienCuuKhoaHoc\Http\Requests\SoLuongNCKHRequest;
use Modules\ThongTinChung\Helpers\TomTat;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SoLuongNCKHController extends Controller
{
    public function index($year)
    {
        $user = Auth::user();
        $this->authorize('index', SoLuongNCKH::class);
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $soLuongNCKH = SoLuongNCKH::where('university_id', $universityId)
            ->where('year', $year)
            ->first();
        $tiLe = TomTat::get($universityId, $year, 'ti_le_de_tai_cb', 0);
        $result = [
            'success' => true,
            'message' => 'Lấy số lượng nghiên cứu khoa học thành công',
            'data' => [
                'so_luong_nckh' => $soLuongNCKH,
                'ti_le_de_tai' => $tiLe
            ]
        ];
        return response()->json($result, 200);
    }

    public function list($year)
    {
        $user = Auth::user();
        $viewYear = $year;
        $this->authorize('index', SoLuongNCKH::class);
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
            $soLuongNCKH = SoLuongNCKH::where('university_id', $universityId)
                ->where('year', $year)
                ->first();
            $data[$year] = $soLuongNCKH;
            $year--;
            $i--;
        }

        $tiLe = TomTat::get($universityId, $viewYear, 'ti_le_de_tai_cb', 0);
        $responseData = [
            'so_luong_nckh' => $data,
            'ti_le_de_tai' => $tiLe
        ];

        $result = [
            'success' => true,
            'message' => 'Lấy số lượng nghiên cứu khoa học thành công',
            'data' => $responseData

        ];
        return response()->json($result, 200);
    }


    public function store($year, SoLuongNCKHRequest $request)
    {

        $user = Auth::user();
        $this->authorize('store', SoLuongNCKH::class);
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

        $soLuongNCKH = SoLuongNCKH::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $universityId
            ],
            $data);
        $tiLe = TomTat::tiLeDeTaiCanBo($universityId, $year);
        TomTat::save($universityId, $year, 'ti_le_de_tai_cb', $tiLe);
        $result = [
            'success' => true,
            'message' => 'Update số lượng nghiên cứu khoa hoc thành công',
            'data' => [
                'so_luong_nckh' => $soLuongNCKH,
                'ti_le' => $tiLe,
            ]
        ];
        return response()->json($result, 200);
    }
}
