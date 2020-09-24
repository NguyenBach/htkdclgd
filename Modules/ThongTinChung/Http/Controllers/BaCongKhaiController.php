<?php


namespace Modules\ThongTinChung\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Modules\ThongTinChung\Helpers\ExportHelper;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BaCongKhaiController extends Controller
{
    public function submit($year, Request $request)
    {
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $export = new ExportHelper();
        $fileName = $export->export($universityId, $year);

    }
}
