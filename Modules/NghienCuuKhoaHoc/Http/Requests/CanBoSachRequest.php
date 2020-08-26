<?php

namespace Modules\NghienCuuKhoaHoc\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CanBoSachRequest extends FormRequest
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
            'chuyen_khao' => 'required|json',
            'giao_trinh' => 'required|json',
            'tham_khao' => 'required|json',
            'huong_dan' => 'required|json',
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
