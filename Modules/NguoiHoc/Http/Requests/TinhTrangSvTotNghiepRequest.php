<?php

namespace Modules\NguoiHoc\Http\Requests;

use App\Http\Requests\APIRequest;

class TinhTrangSvTotNghiepRequest extends APIRequest
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
            'tinh_trang' => 'required|json'
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
