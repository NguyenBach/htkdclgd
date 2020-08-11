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
            'name_en' => '',
            'short_name_vi' => '',
            'short_name_en' => '',
            'name_before' => '',
            'governing_body' => '',
            'address' => '',
            'phone_number' => '',
            'fax_number' => '',
            'email' => '',
            'website' => '',
            'founded_year' => '',
            'k1_start_date' => '',
            'k1_end_date' => '',
            'institution_type' => '',
            'institution_type_other' => '',
            'training_type' => 'json',
            'training_type_other' => ''
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
