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
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Modules\CoSoVatChat\Entities\ThietBi;
use Modules\CoSoVatChat\Entities\TrangThietBi;
use Modules\CoSoVatChat\Http\Requests\ThietBiRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ThietBiController extends Controller
{
    private $thietBiModel = null;

    public function __construct()
    {
        $this->thietBiModel = new ThietBi();
    }

    public function index($year)
    {
        $this->authorize('index', ThietBi::class);
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $thietBi = $this->thietBiModel->where('university_id', $universityId)
            ->where('year', $year)
            ->with('danh_muc_trang_thiet_bi')
            ->get();
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
        $this->authorize('index', ThietBi::class);
        $thietBi->danh_muc_trang_thiet_bi = $thietBi->danh_muc_trang_thiet_bi()->get();
        $result = [
            'success' => true,
            'message' => "Lấy thiết bị thành công",
            'data' => [
                'thiet_bi' => $thietBi
            ]
        ];
        return \response()->json($result);
    }


    public function store(ThietBiRequest $request, $year)
    {
        $this->authorize('create', ThietBi::class);
        $user = Auth::user();
        $data = $request->validated();
        $danhMucTrangThietBi = json_decode($data['danh_muc_trang_thiet_bi']);
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = $request->get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $data['university_id'] = $universityId;
        $data['year'] = $year;
        $thietBi = $this->thietBiModel->create($data);
        $thietBi->danh_muc_trang_thiet_bi()->attach($danhMucTrangThietBi);
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
     */
    public function update(ThietBi $thietBi, ThietBiRequest $request)
    {
        $this->authorize('update', $thietBi);
        $data = $request->validated();

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
     */
    public function destroy(ThietBi $thietBi)
    {
        //
        $this->authorize('update', $thietBi);
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
