<?php

namespace Modules\NguoiHoc\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SvKtx extends Model
{
    use LogsActivity;

    protected $table = 'sv_ktx';
    protected $fillable = [
        'university_id',
        'year',
        'tong_dien_tich',
        'sl_sinh_vien',
        'sl_sv_co_nhu_cau',
        'sl_sv_dc_o',
    ];

    protected static $logAttribute = [
        'tong_dien_tich',
        'sl_sinh_vien',
        'sl_sv_co_nhu_cau',
        'sl_sv_dc_o',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
