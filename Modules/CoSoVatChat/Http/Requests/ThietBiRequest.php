<?php

namespace Modules\CoSoVatChat\Http\Requests;

use App\Http\Requests\APIRequest;

class ThietBiRequest extends APIRequest
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
            'name' => 'required',
            'so_luong' => 'required|numeric',
            'danh_muc_trang_thiet_bi' => 'required|json',
            'doi_tuong' => 'required',
            'dien_tich' => 'required|numeric',
            'hinh_thuc' => 'required'
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
