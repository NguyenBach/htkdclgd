<?php

namespace Modules\NghienCuuKhoaHoc\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class TapChiDuocDang extends Model
{
    use LogsActivity;

    protected $table = 'sl_tap_chi_duoc_dang';

    protected $fillable = [
        'university_id',
        'year',
        'phan_loai_tap_chi_id',
        'danh_muc',
        'so_luong'
    ];

    protected static $logAttributes = [
        'university_id',
        'year',
        'phan_loai_tap_chi_id',
        'danh_muc',
        'so_luong'
    ];

    protected $hidden = [
        'university_id',
        'created_at',
        'updated_at'
    ];
}
