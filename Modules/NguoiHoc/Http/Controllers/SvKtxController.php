<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 03/07/2019
 * Time: 20:32
 */

namespace Modules\NguoiHoc\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\NguoiHoc\Entities\SvKtx;
use Modules\NguoiHoc\Http\Requests\SvKtxRequest;

class SvKtxController extends Controller
{
    public function index($year)
    {
        $user = Auth::user();
        $this->authorize('sv_ktx', SvKtx::class);

        $svktx = SvKtx::where('university_id', $user->university_id)
            ->where('year', $year)
            ->first();

        $result = [
            'success' => true,
            'message' => 'Lấy sinh viên kí túc xá thành công',
            'data' => [
                'sv_ktx' => $svktx
            ]
        ];
        return response()->json($result, 200);
    }


    public function store($year, SvKtxRequest $request)
    {

        $user = Auth::user();
        $this->authorize('sv_ktx', SvKtx::class);
        $data = $request->validated();
        $data['university_id'] = $user->university_id;
        $data['year'] = $year;

        $svKtx = SvKtx::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $user->university_id
            ],
            $data);

        $result = [
            'success' => true,
            'message' => 'Update sinh viên ký túc xá thành công',
            'data' => [
                'sv_ktx' => $svKtx
            ]
        ];
        return response()->json($result, 200);
    }
}