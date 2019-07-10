<?php

namespace Modules\NghienCuuKhoaHoc\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SoLuongSachRequest extends FormRequest
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
            'chuyen_khao' => 'numeric|required',
            'giao_trinh' => 'numeric|required',
            'tham_khao' => 'numeric|required',
            'huong_dan' => 'numeric|required',
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
