<?php

namespace Modules\CoSoVatChat\Http\Requests;

use App\Http\Requests\APIRequest;

class ThuChiRequest extends APIRequest
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
            'tong_nguon_thu' => 'required',
            'tong_hoc_phi' => 'required',
            'chi_nckh' => 'required',
            'thu_nckh' => 'required',
            'chi_dao_tao' => 'required',
            'chi_doi_ngu' => 'required',
            'chi_ket_noi' => 'required'
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
