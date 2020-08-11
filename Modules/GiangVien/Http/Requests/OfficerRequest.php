<?php

namespace Modules\GiangVien\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfficerRequest extends FormRequest
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
            'quan_ly_co_huu' => 'required',
            'quan_ly_hop_dong' => 'required',
            'nhan_vien_co_huu' => 'required',
            'nhan_vien_hop_dong' => 'required'
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
