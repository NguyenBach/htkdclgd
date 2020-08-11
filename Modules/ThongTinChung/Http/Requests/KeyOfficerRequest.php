<?php

namespace Modules\ThongTinChung\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KeyOfficerRequest extends FormRequest
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
            'fullname' => 'required',
            'department_id' => 'required|exists:departments,id',
            'degree' => 'required',
            'position' => 'required',
            'phone_number' => '',
            'email' => 'email'
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
