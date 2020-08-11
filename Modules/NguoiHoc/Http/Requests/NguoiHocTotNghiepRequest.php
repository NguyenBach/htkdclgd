<?php

namespace Modules\NguoiHoc\Http\Requests;

use App\Http\Requests\APIRequest;

class NguoiHocTotNghiepRequest extends APIRequest
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
            'ncs_bv_luan_an_ts' => 'required',
            'hv_tot_nghiep_ch' => 'required',
            'sv_cq_tn_dh' => 'required',
            'sv_kcq_tn_dh' => 'required',
            'sv_kcq_tn_cd' => 'required',
            'sv_cq_tn_cd' => 'required',
            'sv_cq_tn_tc' => 'required',
            'sv_kcq_tn_tc' => 'required',
            'khac' => 'required',
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
