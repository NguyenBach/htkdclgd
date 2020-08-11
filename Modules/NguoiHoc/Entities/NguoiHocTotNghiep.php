<?php

namespace Modules\NguoiHoc\Entities;

use Illuminate\Database\Eloquent\Model;

class NguoiHocTotNghiep extends Model
{
    protected $table = 'nguoi_hoc_tot_nghiep';

    protected $fillable = [
        'university_id',
        'year',
        'ncs_bv_luan_an_ts',
        'hv_tot_nghiep_ch',
        'sv_cq_tn_dh',
        'sv_kcq_tn_dh',
        'sv_kcq_tn_cd',
        'sv_cq_tn_cd',
        'sv_cq_tn_tc',
        'sv_kcq_tn_tc',
        'khac',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
