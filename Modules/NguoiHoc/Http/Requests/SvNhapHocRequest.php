<?php

namespace Modules\NguoiHoc\Http\Requests;

use App\Http\Requests\APIRequest;

class SvNhapHocRequest extends APIRequest
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
            'ncs' => 'required|json',
            'hvch' => 'required|json',
            'dh' => 'required|json',
            'cd' => 'required|json',
            'tc' => 'required|json',
            'khac' => 'required|json',
            'tong_sv' => 'numeric'
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
