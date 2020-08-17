<?php

namespace Modules\NghienCuuKhoaHoc\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class DoanhThuNCKH extends Model
{
    use LogsActivity;

    protected $table = 'doanh_thu_nckh';

    protected $fillable = [
        'university_id',
        'year',
        'dt_nckh_va_cgcn',
        'ti_le_ss_vs_kinh_phi',
        'ti_so_tren_cb_ch'
    ];

    protected static $logAttributes = [
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
