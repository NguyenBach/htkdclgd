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
            'name_vi' => 'required',
            'name_en' => 'required',
            'short_name_vi' => 'required',
            'short_name_en' => 'required',
            'name_before' => 'required',
            'governing_body' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
            'fax_number' => 'required',
            'email' => 'required',
            'website' => 'required',
            'founded_year' => 'required',
            'k1_start_date' => 'required',
            'k1_end_date' => 'required',
            'institution_type' => 'required',
            'institution_type_other' => '',
            'training_type' => 'required',
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
