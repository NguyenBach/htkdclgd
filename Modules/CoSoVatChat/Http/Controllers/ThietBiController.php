<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 05/08/2019
 * Time: 23:14
 */

namespace Modules\CoSoVatChat\Http\Controllers;


use App\Http\Controllers\Controller;
use Cocur\Slugify\Slugify;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\CoSoVatChat\Entities\ThietBi;
use Modules\CoSoVatChat\Entities\TrangThietBi;
use Modules\CoSoVatChat\Http\Requests\ThietBiRequest;

class ThietBiController extends Controller
{
    private $thietBiModel = null;

    public function __construct()
    {
        $this->thietBiModel = new ThietBi();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('thiet_bi', ThietBi::class);
        $user = Auth::user();
        $thietBi = $this->thietBiModel->where('university_id', $user->university_id)->get();
        $thietBi = $thietBi->map(function ($value) {
            $trangThietBi = json_decode($value->danh_muc_trang_thiet_bi);
            $danhMuc = TrangThietBi::whereIn('id', $trangThietBi)->get();
            $value->danh_muc_trang_thiet_bi = $danhMuc->toArray();
            return $value;
        });
        $result = [
            'success' => true,
            'message' => 'Lấy thiết bị thành công',
            'data' => [
                'thiet_bi' => $thietBi
            ]
        ];
        return response()->json($result, 200);
    }

    public function show(ThietBi $thietBi)
    {
        $this->authorize('thiet_bi', ThietBi::class);
        $trangThietBi = json_decode($thietBi->danh_muc_trang_thiet_bi);
        $thietBi->danh_muc_trang_thiet_bi = TrangThietBi::whereIn('id', $trangThietBi)->get()->toArray();
        $result = [
            'success' => true,
            'message' => "Lấy thiết bị thành công",
            'data' => [
                'trang_thiet_bi' => $thietBi
            ]
        ];
        return \response()->json($result);
    }


    /**
     * Store a newly created resource in storage.
     * @param ThietBiRequest $request
     * @throws AuthorizationException
     * @return Response
     */
    public function store(ThietBiRequest $request)
    {
        $this->authorize('thiet_bi', ThietBi::class);
        $user = Auth::user();
        $data = $request->validated();

        $data['university_id'] = $user->university_id;

        $thietBi = $this->thietBiModel->create($data);
        if ($thietBi) {
            $result = [
                'success' => true,
                'message' => 'Tạo thiết bị thành công',
                'data' => [
                    'thiet-bi' => $thietBi
                ]
            ];
            return response()->json($result, 200);
        } else {
            $result = [
                'success' => false,
                'message' => 'Tạo thiết bị thất bại',
            ];
            return response()->json($result, 500);
        }
    }


    /**
     * Update the specified resource in storage.
     * @param ThietBi $thietBi
     * @param ThietBiRequest $request
     * @return Response
     * @throws AuthorizationException
     */
    public function update(ThietBi $thietBi, ThietBiRequest $request)
    {
        $this->authorize('thiet_bi', $thietBi);
        $user = Auth::user();
        $data = $request->validated();

        $data['university_id'] = $user->university_id;

        $success = $thietBi->update($data);

        if ($success) {
            $result = [
                'success' => true,
                'message' => 'sửa thiết bị thành công',
                'data' => [
                    'thiet-bi' => $thietBi
                ]
            ];
            return response()->json($result, 200);
        } else {
            $result = [
                'success' => false,
                'message' => 'Tạo đơn vị thất bại',
            ];
            return response()->json($result, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param ThietBi $thietBi
     * @return Response
     * @throws AuthorizationException
     */
    public function destroy(ThietBi $thietBi)
    {
        //
        $this->authorize('thiet_bi', $thietBi);
        $success = $thietBi->delete();
        if ($success) {
            $result = [
                'success' => true,
                'message' => 'Xóa đơn vị thành công',
            ];
            return response()->json($result, 200);
        } else {
            $result = [
                'success' => false,
                'message' => 'Xóa Đơn vị thất bại ',
            ];
            return response()->json($result, 500);
        }
    }
}