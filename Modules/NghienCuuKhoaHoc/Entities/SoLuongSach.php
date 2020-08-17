<?php

namespace Modules\NghienCuuKhoaHoc\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SoLuongSach extends Model
{
    use LogsActivity;

    protected $table = 'sl_sach_xuat_ban';

    protected $fillable = [
        'year',
        'university_id',
        'loai_sach_id',
        'so_luong'
    ];

    protected static $logAttributes = [
        'year',
        'university_id',
        'loai_sach_id',
        'so_luong'
    ];


    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
