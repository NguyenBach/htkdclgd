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
            'type' => 'required|in:1,2',
            'doi_tuong' => 'required',
            'bo_tieu_chuan' => 'required',
            'nam_hoan_thanh_1' => 'required|numeric',
            'nam_cap_nhat' => 'required|numeric',
            'to_chuc' => 'required',
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
