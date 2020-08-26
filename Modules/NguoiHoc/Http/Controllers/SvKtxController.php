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
use Illuminate\Support\Facades\Input;
use Modules\NguoiHoc\Entities\SvKtx;
use Modules\NguoiHoc\Http\Requests\SvKtxRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SvKtxController extends Controller
{
    public function index($year)
    {
        $user = Auth::user();
        $this->authorize('index', SvKtx::class);

        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $svktx = SvKtx::where('university_id', $universityId)
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
        $this->authorize('store', SvKtx::class);
        $data = $request->validated();

        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $data['university_id'] = $universityId;
        $data['year'] = $year;

        $svKtx = SvKtx::updateOrCreate(
            [
                'year' => $year,
                'university_id' => $universityId
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
