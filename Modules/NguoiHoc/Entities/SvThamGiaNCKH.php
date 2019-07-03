<?php

namespace Modules\NguoiHoc\Entities;

use Illuminate\Database\Eloquent\Model;

class SvThamGiaNCKH extends Model
{
    protected $table = 'sv_tham_gia_nckh';

    protected $fillable = [
        'university_id',
        'year',
        'sl_tham_gia',
        'ti_le'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
