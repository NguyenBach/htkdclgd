<?php

namespace Modules\NghienCuuKhoaHoc\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class CanBoTapChi extends Model
{
    use LogsActivity;

    protected $table = 'sl_cb_viet_tap_chi';
    protected $fillable = [
        'university_id',
        'phan_loai_tap_chi_id',
        'year',
        'tu_1_5',
        'tu_6_10',
        'tu_11_15',
        'tren_15'
    ];

    protected static $logAttributes = [
        'university_id',
        'phan_loai_tap_chi_id',
        'year',
        'tu_1_5',
        'tu_6_10',
        'tu_11_15',
        'tren_15'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
