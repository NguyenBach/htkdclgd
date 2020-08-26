<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 30/07/2019
 * Time: 22:58
 */

namespace Modules\CoSoVatChat\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Modules\CoSoVatChat\Entities\NhomNganh;
use Modules\CoSoVatChat\Entities\SachThuVien;
use Modules\CoSoVatChat\Http\Requests\SachThuVienRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SachThuVienController extends Controller
{
    public function list($year)
    {
        $this->authorize('index', SachThuVien::class);
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $sachThuVien = SachThuVien::where('university_id', $universityId)
            ->where('year', $year)
            ->with('nhomNganh')
            ->get();
        $result = [
            'success' => true,
            'message' => 'lấy sách thành công',
            'data' => [
                'sach_thu_vien' => $sachThuVien
            ]
        ];
        return response()->json($result, 200);
    }

    public function create($year, NhomNganh $nhomNganh, SachThuVienRequest $request)
    {
        $this->authorize('create', SachThuVien::class);
        $data = $request->validated();
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = $request->get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $data['university_id'] = $universityId;

        $sachThuVien = SachThuVien::updateOrCreate([
            'university_id' => $data['university_id'],
            'nhom_nganh_id' => $nhomNganh->id,
            'year' => $year
        ], $data);
        $result = [
            'success' => true,
            'message' => "Tao sách thư viện thành công",
            'data' => [
                'sach_thu_vien' => $sachThuVien
            ]
        ];
        return \response()->json($result);
    }
}
