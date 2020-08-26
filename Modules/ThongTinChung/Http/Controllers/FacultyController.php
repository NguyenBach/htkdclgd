<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 18/06/2019
 * Time: 23:34
 */

namespace Modules\ThongTinChung\Http\Controllers;


use App\Http\Controllers\Controller;
use Cocur\Slugify\Slugify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Modules\ThongTinChung\Entities\EducationType;
use Modules\ThongTinChung\Entities\Faculty;
use Modules\ThongTinChung\Http\Requests\FacultyRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FacultyController extends Controller
{

    private $model;

    public function __construct(Faculty $model)
    {
        $this->model = $model;
    }

    public function list()
    {
        $this->authorize('faculty', Faculty::class);
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $faculties = $this->model->where('university_id', $universityId)
            ->get();
        $faculties = $faculties->map(function ($item) {
            $item->education_type = $item->educationType()->first();
            return $item;
        });
        $result = [
            'success' => true,
            'message' => 'Lấy thông tin thành công',
            'data' => [
                'faculties' => $faculties
            ]
        ];
        return response()->json($result, 200);
    }

    public function create(FacultyRequest $request)
    {
        $this->authorize('faculty', Faculty::class);
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $data = $request->validated();
        if (!isset($data['number_education_program'])) {
            $data['number_education_program'] = 0;
        }
        if (!isset($data['students'])) {
            $data['students'] = 0;
        }

        $data['university_id'] = $universityId;
        $slugify = new Slugify();
        $data['slug'] = $slugify->slugify($data['name']);

        $exist = EducationType::checkExistId($data['education_type'], $universityId);
        if ($exist) {
            $result = [
                'success' => false,
                'message' => 'Loại hình giáo dục không tồn tại',
            ];
            return response()->json($result, 400);
        }

        $facultyExist = Faculty::checkExist($data['slug'], $data['university_id'], $data['education_type']);
        if ($facultyExist) {
            $result = [
                'success' => false,
                'message' => 'Khoa đã tồn tại',
            ];
            return response()->json($result, 400);
        }

        $data['education_type_id'] = $data['education_type'];


        $faculty = $this->model->create($data);
        $faculty->education_type = $faculty->educationType()->first();

        if ($faculty) {
            $result = [
                'success' => true,
                'message' => 'Tạo khoa thành công',
                'data' => [
                    'faculty' => $faculty
                ]
            ];
            return response()->json($result, 200);
        } else {
            $result = [
                'success' => false,
                'message' => 'Tạo khoa thất bại',
            ];
            return response()->json($result, 500);
        }
    }

    public function update(Faculty $faculty, FacultyRequest $request)
    {
        $this->authorize('faculty', Faculty::class);
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $data = $request->validated();
        if (!isset($data['number_education_program'])) {
            $data['number_education_program'] = 0;
        }
        if (!isset($data['students'])) {
            $data['students'] = 0;
        }

        $data['university_id'] = $universityId;
        $slugify = new Slugify();
        $data['slug'] = $slugify->slugify($data['name']);

        $exist = EducationType::checkExistId($data['education_type'], $universityId);
        if ($exist) {
            $result = [
                'success' => false,
                'message' => 'Loại hình giáo dục không tồn tại',
            ];
            return response()->json($result, 400);
        }

        $facultyExist = Faculty::checkExist($data['slug'], $data['university_id'], $data['education_type']);
        if ($facultyExist) {
            $result = [
                'success' => false,
                'message' => 'Khoa đã tồn tại',
            ];
            return response()->json($result, 400);
        }

        $data['education_type_id'] = $data['education_type'];


        $faculty = $this->model->create($data);
        $faculty->education_type = $faculty->educationType()->first();

        if ($faculty) {
            $result = [
                'success' => true,
                'message' => 'Tạo khoa thành công',
                'data' => [
                    'faculty' => $faculty
                ]
            ];
            return response()->json($result, 200);
        } else {
            $result = [
                'success' => false,
                'message' => 'Tạo khoa thất bại',
            ];
            return response()->json($result, 500);
        }
    }
}
