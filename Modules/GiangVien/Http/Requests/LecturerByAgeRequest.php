<?php

namespace Modules\GiangVien\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LecturerByAgeRequest extends FormRequest
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
            'giao_su' => 'required|json',
            'pho_giao_su' => 'required|json',
            'ts_khoa_hoc' => 'required|json',
            'tien_si' => 'required|json',
            'thac_si' => 'required|json',
            'dai_hoc' => 'required|json',
            'cao_dang' => 'required|json',
            'trung_cap' => 'required|json',
            'khac' => 'required|json',
            'avg_age' => ''
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
