<?php

namespace Modules\TuDanhGia\Entities;

use Illuminate\Database\Eloquent\Model;

class DanhGiaNgoai extends Model
{
    protected $table = 'danh_gia_ngoai';

    protected $fillable = [
        'tieu_chuan',
        'tieu_chi',
        'university_id',
        'diem',
        'submit_at'
    ];

    protected $hidden = [
        'role',
    ];


}
