<?php

namespace Modules\GiangVien\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LecturerByFlRequest extends FormRequest
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
            'luon_luon' => 'required|json',
            'thuong_thuong' => 'required|json',
            'doi_khi' => 'required|json',
            'it_khi' => 'required|json',
            'hiem_khi' => 'required|json',
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
