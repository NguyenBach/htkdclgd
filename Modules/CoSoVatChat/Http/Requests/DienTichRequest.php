<?php

namespace Modules\CoSoVatChat\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DienTichRequest extends FormRequest
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
            'tong' => 'required|json',
            'giang_duong' => 'required|json',
            'thu_vien' => 'required|json',
            'trung_tam' => 'required|json'
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
