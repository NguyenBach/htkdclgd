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
use Illuminate\Support\Facades\Auth;
use Modules\GiangVien\Entities\Lecturer;
use Modules\GiangVien\Entities\LecturerByDegree;
use Modules\GiangVien\Entities\Officer;
use Modules\ThongTinChung\Entities\TrainingType;
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
        if (!empty($universityData['institution_type_other'])) {
            $universityData['institution_type'] = 5;
        }
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
        if (is_array($data['training_type_other'])) {
            $data['training_type_other'] = json_encode($data['training_type_other']);
        }
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

    public function destroy(University $model)
    {
        $model->users()->delete();
        $success = $model->delete();
        if ($success) {
            $result = [
                'success' => true,
                'message' => 'Xóa trường đại học thành công',
            ];
            return response()->json($result, 200);
        } else {
            $result = [
                'success' => false,
                'message' => 'Xóa trường đại học thất bại',
            ];
            return response()->json($result, 500);
        }
    }

    public function getTrainingType()
    {
        $traningTypes = TrainingType::all();
        $result = [
            'success' => true,
            'message' => 'Lấy loại hình đào tạo thành công',
            'data' => [
                'training_type' => $traningTypes
            ]
        ];
        return response()->json($result, 200);
    }

    public function tomTat($year, Request $request)
    {
        $user = Auth::user();
        $universityId = $request->get('university_id');
        if ($user->university_id) {
            $universityId = $user->university_id;
        }

        $giangVien = Lecturer::where('university_id', $universityId)
            ->where('year', $year)
            ->first();
        if ($giangVien) {
            $giangVienCoHuu = $giangVien->total_1;
            $tyLeGiangVienTienSi = $giangVien->percent_doctor_1;
        } else {
            $giangVienCoHuu = 0;
            $tyLeGiangVienTienSi = -1;
        }

        $canBoCoHuu = Officer::where('university_id', $universityId)
            ->where('year', $year)
            ->first();
        if ($canBoCoHuu) {
            $quanLyCoHuu = $canBoCoHuu->quan_ly_co_huu;
            $nhanhVienCoHuu = $canBoCoHuu->nhanh_vien_co_huu;
        } else {
            $quanLyCoHuu = 0;
            $nhanhVienCoHuu = 0;
        }
        $tongCanBo = $giangVienCoHuu + $quanLyCoHuu + $nhanhVienCoHuu;
        if (!$tongCanBo) {
            $tyLeGiangVienCanBo = -1;
        } else {
            $tyLeGiangVienCanBo = $giangVienCoHuu / $tongCanBo;
            $tyLeGiangVienCanBo = round($tyLeGiangVienCanBo, 2);
        }

        $giangVienTheoTrinhDo = LecturerByDegree::where('university_id', $universityId)
            ->where('year', $year)
            ->where('lecturer_type', 1)
            ->first();
        $soLuongThacSi = $giangVienTheoTrinhDo ? $giangVienTheoTrinhDo->master : 0;
        $tyLeThacSi = $giangVienCoHuu ? round($soLuongThacSi / $giangVienCoHuu, 2) : -1;

        $data = [
            'tong_giang_vien_co_huu' => $giangVienCoHuu,
            'ty_le_giang_vien_can_bo' => $tyLeGiangVienCanBo,
            'ty_le_tien_si' => $tyLeGiangVienTienSi,
            'ty_le_thac_si' => $tyLeThacSi
        ];

        $result = [
            'success' => true,
            'message' => 'Lấy loại hình đào tạo thành công',
            'data' => [
                'tom_tat' => $data
            ]
        ];

        return response()->json($result, 200);
    }
}
