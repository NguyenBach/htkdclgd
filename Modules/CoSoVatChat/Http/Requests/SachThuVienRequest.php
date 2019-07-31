<?php

namespace Modules\CoSoVatChat\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SachThuVienRequest extends FormRequest
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
            'dau_sach' => 'required|numeric',
            'ban_sach' => 'required|numeric'
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
