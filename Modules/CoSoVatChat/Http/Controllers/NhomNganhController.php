<?php

namespace Modules\CoSoVatChat\Http\Controllers;

use App\Http\Controllers\Controller;
use Cocur\Slugify\Slugify;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\CoSoVatChat\Entities\NhomNganh;
use Modules\CoSoVatChat\Entities\SachThuVien;
use Modules\CoSoVatChat\Http\Requests\NhomNganhRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NhomNganhController extends Controller
{

    public function list()
    {
        $this->authorize('index', SachThuVien::class);
        $nhomNganh = NhomNganh::all();
        $result = [
            'success' => true,
            'message' => "Lấy nhóm ngành thành công",
            'data' => [
                'nhom_nganh' => $nhomNganh
            ]
        ];
        return \response()->json($result);
    }


    public function store(NhomNganhRequest $request)
    {
        $this->authorize('create', NhomNganh::class);
        $data = $request->validated();
        $user = Auth::user();

        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = $request->get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $data['university_id'] = $universityId;
        $data['slug'] = (new Slugify())->slugify($data['name']);

        $nhomNganh = NhomNganh::updateOrCreate([
            'university_id' => $data['university_id'],
            'slug' => $data['slug']
        ], $data);
        $result = [
            'success' => true,
            'message' => "Tao nhóm ngành thành công",
            'data' => [
                'nhom_nganh' => $nhomNganh
            ]
        ];
        return \response()->json($result);
    }


    public function show(NhomNganh $id)
    {
        $result = [
            'success' => true,
            'message' => "lấy nhóm ngành thành công",
            'data' => [
                'nhom_nganh' => $id
            ]
        ];
        return \response()->json($result);
    }


    public function update(NhomNganhRequest $request, NhomNganh $model)
    {
        $this->authorize('update', NhomNganh::class);
        $data = $request->validated();
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = $request->get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $data['university_id'] = $universityId;
        $data['slug'] = (new Slugify())->slugify($data['name']);
        $nhomNganh = $model->update($data);
        $result = [
            'success' => true,
            'message' => "cập nhật nhóm ngành thành công",
            'data' => [
                'nhom_nganh' => $nhomNganh
            ]
        ];
        return \response()->json($result);
    }

    public function destroy(NhomNganh $model)
    {
        //
        $model->delete();
        $result = [
            'success' => true,
            'message' => "Xóa nhóm ngành thành công",
            'data' => [
                'nhom_nganh' => $model
            ]
        ];
        return \response()->json($result);
    }
}
