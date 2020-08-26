<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 06/06/2019
 * Time: 22:12
 */

namespace Modules\ThongTinChung\Http\Controllers;


use App\Http\Controllers\Controller;
use Cocur\Slugify\Slugify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Modules\ThongTinChung\Entities\Department;
use Modules\ThongTinChung\Http\Requests\DeparmentRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DepartmentController extends Controller
{
    private $departmentModel = null;

    public function __construct(Department $model)
    {
        $this->departmentModel = $model;
    }

    public function list()
    {
        $this->authorize('list', Department::class);
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $departments = $this->departmentModel->where('university_id', $universityId)
            ->get();
        $result = [
            'success' => true,
            'message' => 'Lấy thông tin thành công',
            'data' => [
                'departments' => $departments
            ]
        ];
        return response()->json($result, 200);
    }

    public function create(DeparmentRequest $request)
    {
        $this->authorize('create', Department::class);
        $slugify = new Slugify();
        $data = $request->validated();
        $user = Auth::user();

        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $data['slug'] = $slugify->slugify($data['name']);
        $data['university_id'] = $universityId;
        $data['created_by'] = $user->id;
        $exist = Department::checkExist($data['slug'], $data['university_id']);
        if (!$exist) {
            $result = [
                'success' => false,
                'message' => 'Phòng ban này đã tồn tại',
            ];
            return response()->json($result, 400);
        }
        $model = $this->departmentModel->updateOrCreate($data);
        if ($model) {
            $result = [
                'success' => true,
                'message' => 'Tạo trường đại học thành công',
                'data' => [
                    'departments' => $model
                ]
            ];
            return response()->json($result, 200);
        } else {
            $result = [
                'success' => false,
                'message' => 'Tạo phòng ban thất bại',
            ];
            return response()->json($result, 500);
        }

    }

    public function update(Department $department, DeparmentRequest $request)
    {
        $this->authorize('update', $department);
        $data = $request->validated();
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $data['slug'] = $this->createSlug($data['name']);
        $data['university_id'] = $universityId;
        $data['created_by'] = $user->id;
        $model = $department->update($data);
        $department->refresh();
        if ($model) {
            $department->refresh();
            $result = [
                'success' => true,
                'message' => 'Update phòng ban học thành công',
                'data' => [
                    'departments' => $department
                ]
            ];
            return response()->json($result, 200);
        } else {
            $result = [
                'success' => false,
                'message' => 'Update phòng ban học thất bại',
            ];
            return response()->json($result, 500);
        }

    }

    public function delete(Department $department)
    {
        $this->authorize('delete', $department);
        $success = $department->delete();
        if ($success) {
            $result = [
                'success' => true,
                'message' => 'Xóa phòng ban học thành công',
            ];
            return response()->json($result, 200);
        } else {
            $result = [
                'success' => false,
                'message' => 'Xóa phòng ban học thất bại ',
            ];
            return response()->json($result, 500);
        }
    }

    private function createSlug($string)
    {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
        return $slug;
    }
}
