<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 29/07/2019
 * Time: 22:45
 */

namespace Modules\NghienCuuKhoaHoc\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\NghienCuuKhoaHoc\Entities\BangSangChe;
use Modules\NghienCuuKhoaHoc\Http\Requests\BangSangCheRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BangSangCheController extends Controller
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
        $this->authorize('index', BangSangChe::class);

        $bangSangChe = BangSangChe::where('university_id', $universityId)
            ->where('year', $year)
            ->first();

        $result = [
            'success' => true,
            'message' => 'Lấy bằng sáng chế thành công',
            'data' => [
                'bang_sang_che' => $bangSangChe
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
        $this->authorize('index', BangSangChe::class);

        $data = [];
        $i = 5;
        while ($i > 0) {
            $bangSangChe = BangSangChe::where('university_id', $universityId)
                ->where('year', $year)
                ->first();
            $data[$year] = [
                'bang_sang_che' => $bangSangChe
            ];
            $year--;
            $i--;
        }


        $result = [
            'success' => true,
            'message' => 'Lấy bằng sáng chế thành công',
            'data' => $data
        ];
        return response()->json($result, 200);
    }


    public function store($year, BangSangCheRequest $request)
    {

        $user = Auth::user();
        $this->authorize('store', BangSangChe::class);
        $data = $request->validated();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = $request->get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $data['university_id'] = $universityId;
        $data['year'] = $year;

        $bangSangChe = BangSangChe::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $universityId
            ],
            $data);

        $result = [
            'success' => true,
            'message' => 'Update bằng sáng chế thành công',
            'data' => [
                'bang_sang_che' => $bangSangChe
            ]
        ];
        return response()->json($result, 200);
    }
}
