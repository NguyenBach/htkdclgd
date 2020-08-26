<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 19/08/2019
 * Time: 22:42
 */

namespace Modules\KiemDinhChatLuong\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\KiemDinhChatLuong\Entities\DoiTuongKiemDinh;
use Modules\KiemDinhChatLuong\Http\Requests\DoiTuongKiemDinhRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DoiTuongKiemDinhController extends Controller
{

    public function list(Request $request)
    {
        $this->authorize('doi_tuong_kiem_dinh', DoiTuongKiemDinh::class);
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = $request->get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $doiTuong = DoiTuongKiemDinh::where('university_id', $universityId)->get();
        $result = [
            'success' => 'true',
            'message' => 'Lấy đối tượng kiểm định thành công',
            'data' => [
                'doi_tuong' => $doiTuong,
            ]
        ];
        return response()->json($result);
    }

    public function store(DoiTuongKiemDinhRequest $request)
    {
        $this->authorize('store', DoiTuongKiemDinh::class);
        $user = Auth::user();
        $data = $request->validated();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = $request->get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $data['university_id'] = $universityId;
        $doiTuong = DoiTuongKiemDinh::create($data);
        $result = [
            'success' => 'true',
            'message' => 'Create đối tượng kiểm định thành công',
            'data' => [
                'doi_tuong' => $doiTuong,
            ]
        ];
        return response()->json($result);
    }

    public function update(DoiTuongKiemDinh $doiTuong, DoiTuongKiemDinhRequest $request)
    {
        $this->authorize('update', DoiTuongKiemDinh::class);
        $data = $request->validated();
        $doiTuong->update($data);
        $doiTuong->refresh();
        $result = [
            'success' => 'true',
            'message' => 'Update đối tượng kiểm định thành công',
            'data' => [
                'doi_tuong' => $doiTuong,
            ]
        ];
        return response()->json($result);
    }

    public function delete(DoiTuongKiemDinh $doiTuong)
    {
        $this->authorize('update', DoiTuongKiemDinh::class);
        $doiTuong->delete();
        $result = [
            'success' => 'true',
            'message' => 'Delete đối tượng kiểm định thành công',
            'data' => [
                'doi_tuong' => $doiTuong,
            ]
        ];
        return response()->json($result);
    }
}
