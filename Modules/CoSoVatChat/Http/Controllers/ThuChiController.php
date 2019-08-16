<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 16/08/2019
 * Time: 22:19
 */

namespace Modules\CoSoVatChat\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\CoSoVatChat\Entities\ThuChi;
use Modules\CoSoVatChat\Http\Requests\ThuChiRequest;

class ThuChiController extends Controller
{

    public function list($year, Request $request)
    {
        $this->authorize('thu_chi', ThuChi::class);
        $user = Auth::user();
        $thuChi = ThuChi::where('year', $year)
            ->where('university_id', $user->university_id)
            ->first();
        $result = [
            'success' => true,
            'message' => 'Lấy thu chi thành công',
            'data' => [
                'thu_chi' => $thuChi
            ]
        ];
        return response()->json($result);
    }

    public function update($year, ThuChiRequest $request)
    {
        $this->authorize('thu_chi', ThuChi::class);
        $data = $request->validated();
        $user = Auth::user();
        $thuChi = ThuChi::updateOrCreate([
            'university_id' => $user->university_id,
            'year' => $year
        ], $data);
        $result = [
            'success' => true,
            'message' => 'Update thu chi thành công',
            'data' => [
                'thu_chi' => $thuChi
            ]
        ];
        return response()->json($result);
    }
}