<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 13/06/2019
 * Time: 23:27
 */

namespace Modules\ThongTinChung\Http\Controllers;


use App\Http\Controllers\Controller;
use Defuse\Crypto\Key;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Entities\Permission;
use Modules\ThongTinChung\Entities\Department;
use Modules\ThongTinChung\Entities\KeyOfficer;
use Modules\ThongTinChung\Http\Requests\KeyOfficerRequest;

class KeyOfficerController extends Controller
{
    private $keyOfficerModel = null;

    public function __construct(KeyOfficer $keyOfficer)
    {
        $this->keyOfficerModel = $keyOfficer;
    }

    public function list()
    {
        $this->authorize('key_officer', KeyOfficer::class);
        $user = Auth::user();
        $university_id = $user->university_id;
        $keyOfficers = KeyOfficer::where('university_id', $university_id)->get();
        $result = [
            'success' => true,
            'message' => 'Lấy danh sách cán bộ thành công',
            'data' => $keyOfficers
        ];
        return response()->json($result, 200);
    }

    public function create(KeyOfficerRequest $request)
    {
        $this->authorize('key_officer', KeyOfficer::class);
        $user = Auth::user();
        $data = $request->validated();
        $departmentExist = Department::checkExistInUniversity($data['department_id'], $user->university_id);
        if (!$departmentExist) {

        }
    }
}