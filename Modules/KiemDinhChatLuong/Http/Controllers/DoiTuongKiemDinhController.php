<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 19/08/2019
 * Time: 22:42
 */

namespace Modules\KiemDinhChatLuong\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\KiemDinhChatLuong\Entities\DoiTuongKiemDinh;
use Modules\KiemDinhChatLuong\Http\Requests\DoiTuongKiemDinhRequest;

class DoiTuongKiemDinhController extends Controller
{

    public function list()
    {
        $this->authorize('doi_tuong_kiem_dinh', DoiTuongKiemDinh::class);
        $user = Auth::user();
        $doiTuong = DoiTuongKiemDinh::where('university_id', $user->university_id)->get();
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
        $this->authorize('doi_tuong_kiem_dinh', DoiTuongKiemDinh::class);
        $user = Auth::user();
        $data = $request->validated();
        $data['university_id'] = $user->university_id;
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
        $this->authorize('doi_tuong_kiem_dinh', DoiTuongKiemDinh::class);
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
        $this->authorize('doi_tuong_kiem_dinh', DoiTuongKiemDinh::class);
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