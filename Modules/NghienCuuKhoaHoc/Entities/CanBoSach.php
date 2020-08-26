<?php

namespace Modules\NghienCuuKhoaHoc\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class CanBoSach extends Model
{
    use LogsActivity;

    protected $table = 'sl_cb_viet_sach';
    protected $fillable = [
        'university_id',
        'loai_sach_id',
        'year',
        'tu_1_3',
        'tu_4_6',
        'tren_6'
    ];

    protected static $logAttributes = [
        'university_id',
        'loai_sach_id',
        'year',
        'tu_1_3',
        'tu_4_6',
        'tren_6'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
