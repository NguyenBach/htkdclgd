<?php


namespace Modules\ThongTinChung\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Modules\ThongTinChung\Entities\BaoCaoBaCongKhai;
use Modules\ThongTinChung\Helpers\ExportHelper;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BaCongKhaiController extends Controller
{
    public function submit($year)
    {
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        if ($year != date('Y')) {
            $year = date('Y');
        }
        $export = new ExportHelper();
        $fileName = $export->export($universityId, $year);
        BaoCaoBaCongKhai::create([
            'university_id' => $universityId,
            'year' => $year,
            'user_id' => $user->id,
            'filename' => $fileName,
            'submitted_at' => date('Y-m-d H:i:s')
        ]);
        $result = [
            'success' => true,
            'message' => 'Nộp thành công',
        ];
        return response()->json($result, 200);
    }

    public function submitHistory($year)
    {
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $history = BaoCaoBaCongKhai::where('university_id', $universityId)
            ->where('year', $year)
            ->orderBy('submitted_at', 'desc')->with('user')->get();

        $result = [
            'success' => true,
            'message' => 'Lay thành công',
            'data' => [
                'history' => $history
            ]
        ];
        return response()->json($result, 200);
    }
}
