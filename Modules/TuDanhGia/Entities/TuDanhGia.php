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
        'moc_chuan',
        'minh_chung',
        'diem_thong_nhat',
    ];

    protected $hidden = [
        'role',
//        'diem_minh_chung',
//        'diem_moc_chuan'
    ];

    protected $casts = [
        'moc_chuan' => 'array',
        'minh_chung' => 'array'
    ];

}
