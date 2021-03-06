<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 14/06/2019
 * Time: 23:04
 */

namespace Modules\ThongTinChung\Http\Controllers;


use App\Http\Controllers\Controller;
use Cocur\Slugify\Slugify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Modules\ThongTinChung\Entities\EducationType;
use Modules\ThongTinChung\Http\Requests\EducationTypeRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EducationTypeController extends Controller
{
    private $model = null;

    public function __construct(EducationType $model)
    {
        $this->model = $model;
    }

    public function list($year)
    {
        $this->authorize('index', EducationType::class);
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $types = $this->model
            ->where('university_id', $universityId)
            ->where('year', $year)
            ->orderBy('order')
            ->get();
        $result = [
            'success' => true,
            'message' => 'Lấy thông tin thành công',
            'data' => [
                'education_types' => $types
            ]
        ];
        return response()->json($result, 200);
    }

    public function create($year, EducationTypeRequest $request)
    {
        $this->authorize('create', EducationType::class);
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
        $data['year'] = $year;
        $data['university_id'] = $universityId;
        $data['created_by'] = $user->id;
        if (!$data['order']) {
            $lastOrder = EducationType::select(['order'])->where('university_id', $universityId)->where('year', $year)
                ->orderBy('order', 'desc')->first();
            if ($lastOrder) {
                $lastOrder = $lastOrder->order;
            } else {
                $lastOrder = 0;
            }
            $data['order'] = $lastOrder + 1;
        }

        $exist = EducationType::checkExist($data['slug'], $data['university_id'], $year);
        if (!$exist) {
            $result = [
                'success' => false,
                'message' => 'Phòng ban này đã tồn tại',
            ];
            return response()->json($result, 400);
        }

        $model = $this->model->create($data);

        if ($model) {
            $result = [
                'success' => true,
                'message' => 'Tạo trường đại học thành công',
                'data' => [
                    'education_type' => $model
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

    public function update(EducationType $educationType, EducationTypeRequest $request)
    {
        $this->authorize('update', $educationType);
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
        if (!$data['order']) {
            $lastOrder = EducationType::select(['order'])->where('university_id', $universityId)->orderBy('order', 'desc')->first();
            if ($lastOrder) {
                $lastOrder = $lastOrder->order;
            } else {
                $lastOrder = 0;
            }
            $data['order'] = $lastOrder + 1;
        }
        $model = $educationType->update($data);
        if ($model) {
            $educationType->refresh();
            $result = [
                'success' => true,
                'message' => 'Update phòng ban học thành công',
                'data' => [
                    'departments' => $model
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

    public function delete(EducationType $model)
    {
        $this->authorize('delete', $model);

        $success = $model->delete();

        if ($success) {
            $result = [
                'success' => true,
                'message' => 'Xóa loại hình đào tạo thành công',
            ];
            return response()->json($result, 200);
        } else {
            $result = [
                'success' => false,
                'message' => 'Xóa loại hình đào tạo thất bại ',
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
