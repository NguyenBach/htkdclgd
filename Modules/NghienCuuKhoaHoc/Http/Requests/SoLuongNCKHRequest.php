<?php

namespace Modules\NghienCuuKhoaHoc\Http\Requests;

use App\Http\Requests\APIRequest;

class SoLuongNCKHRequest extends APIRequest
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
            'dt_cap_nha_nuoc' => 'required|numeric',
            'dt_cap_bo' => 'required|numeric',
            'dt_cap_truong' => 'required|numeric'
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
