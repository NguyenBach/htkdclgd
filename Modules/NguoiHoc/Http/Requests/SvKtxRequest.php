<?php

namespace Modules\NguoiHoc\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SvKtxRequest extends FormRequest
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
            'tong_dien_tich' => 'required',
            'sl_sinh_vien' => 'required',
            'sl_sv_co_nhu_cau' => 'required',
            'sl_sv_dc_o' => 'required'
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
