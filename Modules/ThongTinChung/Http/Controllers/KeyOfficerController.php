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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Modules\Auth\Entities\Permission;
use Modules\ThongTinChung\Entities\Department;
use Modules\ThongTinChung\Entities\KeyOfficer;
use Modules\ThongTinChung\Http\Requests\KeyOfficerRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class KeyOfficerController extends Controller
{
    private $keyOfficerModel = null;

    public function __construct(KeyOfficer $keyOfficer)
    {
        $this->keyOfficerModel = $keyOfficer;
    }

    public function list()
    {
        $this->authorize('list', KeyOfficer::class);
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $keyOfficers = KeyOfficer::where('university_id', $universityId)->get();
        $result = [
            'success' => true,
            'message' => 'Lấy danh sách cán bộ thành công',
            'data' => $keyOfficers
        ];
        return response()->json($result, 200);
    }

    public function create(KeyOfficerRequest $request)
    {
        $this->authorize('create', KeyOfficer::class);
        $user = Auth::user();
        $data = $request->validated();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $departmentExist = Department::checkExistInUniversity($data['department_id'], $universityId);
        if (!$departmentExist) {
            $result = [
                'success' => false,
                'message' => 'Không tìm thấy phòng ban cần thêm',
            ];
            return response()->json($result, 400);
        }
        $data['university_id'] = $universityId;
        $keyOfficer = KeyOfficer::create($data);
        if (!$keyOfficer) {
            $result = [
                'success' => false,
                'message' => 'Thêm cán bộ thất bại',
            ];
            return response()->json($result, 500);
        }

        $keyOfficer->departments = $keyOfficer->department()->first();
        $result = [
            'success' => true,
            'message' => 'Thêm cán bộ thành công',
            'data' => [
                'key_officer' => $keyOfficer
            ]
        ];
        return response()->json($result, 200);
    }

    public function update(KeyOfficer $keyOfficer, KeyOfficerRequest $request)
    {
        $this->authorize('update', $keyOfficer);
        $user = Auth::user();
        $data = $request->validated();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $departmentExist = Department::checkExistInUniversity($data['department_id'], $universityId);
        if (!$departmentExist) {
            $result = [
                'success' => false,
                'message' => 'Không tìm thấy phòng ban cần thêm',
            ];
            return response()->json($result, 400);
        }
        $data['university_id'] = $universityId;
        $success = $keyOfficer->update($data);
        if (!$success) {
            $result = [
                'success' => false,
                'message' => 'Sửa cán bộ thất bại',
            ];
            return response()->json($result, 500);
        }
        $keyOfficer->refresh();
        $keyOfficer->departments = $keyOfficer->department();
        $result = [
            'success' => true,
            'message' => 'Sửa cán bộ thành công',
            'data' => [
                'key_officer' => $keyOfficer
            ]
        ];
        return response()->json($result, 200);
    }

    public function delete(KeyOfficer $keyOfficer, Request $request)
    {
        $this->authorize('delete', $keyOfficer);
        $success = $keyOfficer->delete();
        if ($success) {
            $result = [
                'success' => true,
                'message' => 'Xóa cán bộ thành công',
            ];
            return response()->json($result, 200);
        } else {
            $result = [
                'success' => false,
                'message' => 'Xóa cán bộ thất bại ',
            ];
            return response()->json($result, 500);
        }
    }
}
