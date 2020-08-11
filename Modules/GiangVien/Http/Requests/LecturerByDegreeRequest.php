<?php

namespace Modules\GiangVien\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LecturerByDegreeRequest extends FormRequest
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
            'bien_che' => 'json|required',
            'dai_han' => 'required|json',
            'quan_ly' => 'required|json',
            'trong_nuoc' => 'required|json',
            'quoc_te' => 'required|json'
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
