<?php

namespace Modules\NghienCuuKhoaHoc\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThanhTichRequest extends FormRequest
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
            'bai_bao' => 'required|numeric',
            'giai_thuong' => 'required|numeric'
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
