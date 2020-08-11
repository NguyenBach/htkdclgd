<?php

namespace Modules\NghienCuuKhoaHoc\Entities;

use Illuminate\Database\Eloquent\Model;

class SoLuongSach extends Model
{
    protected $table = 'sl_sach_xuat_ban';

    protected $fillable = [
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
