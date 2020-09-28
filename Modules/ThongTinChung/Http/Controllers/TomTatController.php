<?php


namespace Modules\ThongTinChung\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Modules\ThongTinChung\Entities\TomTatChiSo;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TomTatController extends Controller
{

    public function show($year)
    {
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $tomTat = TomTatChiSo::where('university_id', $universityId)
            ->where('year', $year)->first();

        $result = [
            'success' => true,
            'message' => 'Lấy thông tin thành công',
            'data' => [
                'tom_tat' => $tomTat
            ]
        ];
        return response()->json($result, 200);
    }

    public function update($year, Request $request)
    {
        $data = $request->all();
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $tomTat = TomTatChiSo::where('university_id', $universityId)
            ->where('year', $year)->first();
        if (!$tomTat) {
            $tomTat = new TomTatChiSo();
            $tomTat->university_id = $universityId;
            $tomTat->year = $year;
        }

        foreach ($data as $key => $value) {
            if(in_array($key,$tomTat->getFillable())){
                $tomTat->$key = $value;
            }
        }

        $tomTat->save();
        $tomTat->refresh();
        $result = [
            'success' => true,
            'message' => 'Lấy thông tin thành công',
            'data' => [
                'tom_tat' => $tomTat
            ]
        ];
        return response()->json($result, 200);
    }

    public function tinhToan($year)
    {
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $tomTat = TomTatChiSo::where('university_id', $universityId)
            ->where('year', $year)->first();
        if (!$tomTat) {
            $tomTat = new TomTatChiSo();
            $tomTat->university_id = $universityId;
            $tomTat->year = $year;
        }

        //Tinh toan o day

        $tomTat->save();
        $tomTat->refresh();
        $result = [
            'success' => true,
            'message' => 'Lấy thông tin thành công',
            'data' => [
                'tom_tat' => $tomTat
            ]
        ];
        return response()->json($result, 200);
    }
}
