<?php

namespace Modules\GiangVien\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfficerByGenderRequest extends FormRequest
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
            'bien_che_nam' => 'required',
            'bien_che_nu' => 'required',
            'dai_han_nam' => 'required',
            'dai_han_nu' => 'required',
            'ngan_han_nam' => 'required',
            'ngan_han_nu' => 'required',
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
