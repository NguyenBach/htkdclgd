<?php

namespace Modules\TuDanhGia\Entities;

use Illuminate\Database\Eloquent\Model;

class TuDanhGia extends Model
{
    protected $table = 'tu_danh_gia';

    protected $fillable = [
        'role',
        'tieu_chuan',
        'tieu_chi',
        'university_id',
        'diem',
    ];

    protected $hidden = [
        'role',
        'university_id',
        'created_at',
        'updated_at'
    ];


}
