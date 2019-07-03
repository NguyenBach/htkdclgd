<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 03/07/2019
 * Time: 22:15
 */

namespace Modules\NguoiHoc\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\NguoiHoc\Entities\SvThamGiaNCKH;
use Modules\NguoiHoc\Http\Requests\SvThamGiaNCKHRequest;

class SvThamGiaNCKHController extends Controller
{
    public function index($year)
    {
        $user = Auth::user();
        $this->authorize('sv_tham_gia_nckh', SvThamGiaNCKH::class);

        $svktx = SvThamGiaNCKH::where('university_id', $user->university_id)
            ->where('year', $year)
            ->first();

        $result = [
            'success' => true,
            'message' => 'Lấy sinh viên tham gia nckh thành công',
            'data' => [
                'sv_tham_gia_nckh' => $svktx
            ]
        ];
        return response()->json($result, 200);
    }


    public function store($year, SvThamGiaNCKHRequest $request)
    {

        $user = Auth::user();
        $this->authorize('sv_tham_gia_nckh', SvThamGiaNCKH::class);
        $data = $request->validated();
        $data['university_id'] = $user->university_id;
        $data['year'] = $year;

        $svKtx = SvThamGiaNCKH::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $user->university_id
            ],
            $data);

        $result = [
            'success' => true,
            'message' => 'Update sinh viên tham gia nckh thành công',
            'data' => [
                'sv_tham_gia_nckh' => $svKtx
            ]
        ];
        return response()->json($result, 200);
    }
}