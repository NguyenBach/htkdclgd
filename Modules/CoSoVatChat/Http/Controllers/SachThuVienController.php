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
use Modules\CoSoVatChat\Entities\NhomNganh;
use Modules\CoSoVatChat\Entities\SachThuVien;
use Modules\CoSoVatChat\Http\Requests\SachThuVienRequest;

class SachThuVienController extends Controller
{
    public function list($year)
    {
        $user = Auth::user();
        $sachThuVien = SachThuVien::where('university_id', $user->university_id)
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

    public function create($year,NhomNganh $nhomNganh, SachThuVienRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();
        $data['university_id'] = $user->university_id;

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