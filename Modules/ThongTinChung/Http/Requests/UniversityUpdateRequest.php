<?php

namespace Modules\ThongTinChung\Http\Requests;

use App\Http\Requests\APIRequest;

class UniversityUpdateRequest extends APIRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_vi' => '',
            'governing_body' => '',
            'institution_type' => '',
            'institution_type_other' => '',
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
