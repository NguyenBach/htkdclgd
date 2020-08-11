<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 29/07/2019
 * Time: 22:45
 */

namespace Modules\NghienCuuKhoaHoc\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\NghienCuuKhoaHoc\Entities\BangSangChe;
use Modules\NghienCuuKhoaHoc\Http\Requests\BangSangCheRequest;

class BangSangCheController extends Controller
{
    public function index($year)
    {
        $user = Auth::user();
        $this->authorize('bang_sang_che', BangSangChe::class);

        $bangSangChe = BangSangChe::where('university_id', $user->university_id)
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


    public function store($year, BangSangCheRequest $request)
    {

        $user = Auth::user();
        $this->authorize('bang_sang_che', BangSangChe::class);
        $data = $request->validated();
        $data['university_id'] = $user->university_id;
        $data['year'] = $year;

        $bangSangChe = BangSangChe::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $user->university_id
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