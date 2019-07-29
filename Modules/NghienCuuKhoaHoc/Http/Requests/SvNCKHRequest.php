<?php

namespace Modules\NghienCuuKhoaHoc\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SvNCKHRequest extends FormRequest
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
            'nha_nuoc' => 'required|json',
            'cap_bo' => 'required|json',
            'cap_truong' => 'required|json',
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
