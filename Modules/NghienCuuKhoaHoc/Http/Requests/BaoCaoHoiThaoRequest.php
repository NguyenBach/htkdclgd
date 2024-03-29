<?php

namespace Modules\NghienCuuKhoaHoc\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaoCaoHoiThaoRequest extends FormRequest
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
            'quoc_te' => 'numeric|required',
            'trong_nuoc' => 'numeric|required',
            'cap_truong' => 'numeric|required',

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
