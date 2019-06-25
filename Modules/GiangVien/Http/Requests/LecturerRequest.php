<?php

namespace Modules\GiangVien\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LecturerRequest extends FormRequest
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
            'giang_vien' => 'required|json',
            'nghien_cuu_vien' => 'required|json'
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
