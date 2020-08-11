<?php

namespace Modules\KiemDinhChatLuong\Http\Requests;

use App\Http\Requests\APIRequest;

class KiemDinhChatLuongRequest extends APIRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'doi_tuong' => 'required|exists:doi_tuong_kiem_dinhs,id',
            'bo_tieu_chuan' => 'required|exists:tieu_chuan_kiem_dinhs,id',
            'nam_hoan_thanh_1' => 'required|numeric',
            'nam_cap_nhat' => 'required|numeric',
            'to_chuc' => 'required|exists:to_chuc_kiem_dinh,id',
            'nam_danh_gia' => 'required',
            'ket_qua' => 'required',
            'ngay_cap' => 'required',
            'gia_tri_den' => 'required',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
