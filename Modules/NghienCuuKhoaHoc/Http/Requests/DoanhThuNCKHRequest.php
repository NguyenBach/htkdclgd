<?php

namespace Modules\NghienCuuKhoaHoc\Http\Requests;

use App\Http\Requests\APIRequest;

class DoanhThuNCKHRequest extends APIRequest
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
            'dt_nckh_va_cgcn' => 'required',
            'ti_le_ss_vs_kinh_phi' => 'required',
            'ti_so_tren_cb_ch' => 'required'
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
