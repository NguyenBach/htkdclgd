<?php

namespace Modules\NghienCuuKhoaHoc\Entities;

use Illuminate\Database\Eloquent\Model;

class ThanhTich extends Model
{
    protected $table = 'thanh_tich_nckh';

    protected $fillable = [
        'year',
        'university_id',
        'giai_thuong',
        'bai_bao',

    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];
}
