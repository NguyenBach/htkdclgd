<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 04/06/2019
 * Time: 22:29
 */

namespace Modules\ThongTinChung\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\ThongTinChung\Entities\University;
use Modules\ThongTinChung\Http\Requests\UniversityRequest;
use Modules\ThongTinChung\Http\Requests\UniversityUpdateRequest;

class UniversityController extends Controller
{
    private $universityModel = null;

    public function __construct(University $university)
    {
        $this->universityModel = $university;
    }

    public function list(Request $request)
    {
        $this->authorize('list', University::class);
        $universities = $this->universityModel->all();
        $result = [
            'success' => true,
            'message' => 'Lấy thông tin thành công',
            'data' => [
                'university' => $universities
            ]
        ];
        return response()->json($result, 200);
    }

    public function view(University $model)
    {
        $this->authorize('view', $model);
        $result = [
            'success' => true,
            'message' => 'Lấy thông tin thành công',
            'data' => [
                'university' => $model
            ]
        ];
        return response()->json($result, 200);
    }

    public function create(UniversityRequest $request)
    {
        $this->authorize('create', University::class);
        $universityData = $request->validated();
        $university = $this->universityModel->create($universityData);
        $result = [
            'success' => true,
            'message' => 'Tạo trường đại học thành công',
            'data' => [
                'university' => $university
            ]
        ];
        return response()->json($result, 200);
    }

    public function update(University $model, UniversityUpdateRequest $request)
    {
        $this->authorize('update', $model);
        $data = $request->validated();
        $success = $model->update($data);
        if ($success) {
            $model->refresh();
            $result = [
                'success' => true,
                'message' => 'Cập nhật trường đại học thành công',
                'data' => [
                    'university' => $model
                ]
            ];
            return response()->json($result, 200);
        } else {
            $result = [
                'success' => false,
                'message' => 'Cập nhật trường đại học thất bại',
            ];
            return response()->json($result, 500);
        }

    }
}