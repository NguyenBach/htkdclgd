<?php

namespace Modules\NghienCuuKhoaHoc\Entities;

use Illuminate\Database\Eloquent\Model;

class DoanhThuNCKH extends Model
{
    protected $table = 'doanh_thu_nckh';

    protected $fillable = [
        'university_id',
        'year',
        'dt_nckh_va_cgcn',
        'ti_le_ss_vs_kinh_phi',
        'ti_so_tren_cb_ch'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
