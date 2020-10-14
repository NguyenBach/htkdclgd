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

    public function list($year = 2020)
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
            ->where('year', $year)
            ->get();
        $result = [
            'success' => true,
            'message' => 'Lấy thông tin thành công',
            'data' => [
                'faculties' => $faculties
            ]
        ];
        return response()->json($result, 200);
    }

    public function copy($year)
    {
        $copyYear = Input::get('copy_year');
        $this->authorize('index', Faculty::class);
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $faculty = Faculty::where('university_id', $universityId)
            ->where('year', $copyYear)
            ->get();
        $educationType = EducationType::where('university_id', $universityId)
            ->where('year', $copyYear)
            ->get();

        $faculty->map(function ($item) use ($year) {
            $newData = $item->replicate();
            $newData->year = $year;
            $newData->save();
        });
        $educationType->map(function ($item) use ($year) {
            $newData = $item->replicate();
            $newData->year = $year;
            $newData->save();
        });
        $result = [
            'success' => true,
            'message' => 'Sao chép danh sách thành công',
        ];
        return response()->json($result, 200);
    }

    public function create(FacultyRequest $request, $year = 2020)
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
        $data['university_id'] = $universityId;
        $data['year'] = $year;
        $slugify = new Slugify();
        $data['slug'] = $slugify->slugify($data['name']);

        $facultyExist = Faculty::checkExist($data['slug'], $data['university_id'], $year);
        if ($facultyExist) {
            $result = [
                'success' => false,
                'message' => 'Khoa đã tồn tại',
            ];
            return response()->json($result, 400);
        }

        $faculty = $this->model->create($data);
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

        $data['university_id'] = $universityId;
        $slugify = new Slugify();
        $data['slug'] = $slugify->slugify($data['name']);

        if ($faculty->slug != $data['slug']) {
            $facultyExist = Faculty::checkExist($data['slug'], $data['university_id']);
            if ($facultyExist) {
                $result = [
                    'success' => false,
                    'message' => 'Khoa đã tồn tại',
                ];
                return response()->json($result, 400);
            }
        }

        $faculty->update($data);

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

    public function delete(Faculty $faculty)
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
        if ($faculty->university_id != $universityId) {
            return response()->json([
                'success' => false,
                'message' => 'Không được phép',
            ], 403);
        }

        $faculty->delete();
        return response()->json([
            'success' => true,
            'message' => 'Xóa thành công',
        ], 200);
    }
}
