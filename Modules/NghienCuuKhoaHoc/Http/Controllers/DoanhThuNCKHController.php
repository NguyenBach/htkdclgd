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
use Illuminate\Support\Facades\Input;
use Modules\NghienCuuKhoaHoc\Entities\DoanhThuNCKH;
use Modules\NghienCuuKhoaHoc\Http\Requests\DoanhThuNCKHRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DoanhThuNCKHController extends Controller
{
    public function index($year)
    {
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $this->authorize('index', DoanhThuNCKH::class);

        $doanhThuNCKH = DoanhThuNCKH::where('university_id', $universityId)
            ->where('year', $year)
            ->first();

        $result = [
            'success' => true,
            'message' => 'Lấy doanh thu nghiên cứu khoa học thành công',
            'data' => [
                'doanh_thu_nckh' => $doanhThuNCKH
            ]
        ];
        return response()->json($result, 200);
    }

    public function list($year)
    {
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $this->authorize('index', DoanhThuNCKH::class);

        $data = [];
        $i = 5;
        while ($i > 0) {
            $doanhThuNCKH = DoanhThuNCKH::where('university_id', $universityId)
                ->where('year', $year)
                ->first();
            $data[$year] = [
                'doanh_thu_nckh' => $doanhThuNCKH
            ];
            $year--;
            $i--;
        }

        $result = [
            'success' => true,
            'message' => 'Lấy doanh thu nghiên cứu khoa học thành công',
            'data' => $data
        ];
        return response()->json($result, 200);
    }


    public function store($year, DoanhThuNCKHRequest $request)
    {

        $user = Auth::user();
        $this->authorize('store', DoanhThuNCKH::class);
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

        $doanhThuNCKH = DoanhThuNCKH::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $universityId
            ],
            $data);

        $result = [
            'success' => true,
            'message' => 'Update doanh thu nghiên cứu khoa hoc thành công',
            'data' => [
                'doanh_thu_nckh' => $doanhThuNCKH
            ]
        ];
        return response()->json($result, 200);
    }
}
