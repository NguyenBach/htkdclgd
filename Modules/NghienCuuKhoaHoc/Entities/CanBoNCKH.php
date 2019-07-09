<?php

namespace Modules\NghienCuuKhoaHoc\Entities;

use Illuminate\Database\Eloquent\Model;

class CanBoNCKH extends Model
{
    protected $table = 'cb_tham_gia_nckh';
    protected $fillable = [
        'year',
        'university_id',
        'cap_de_tai_id',
        'tu_1_3',
        'tu_4_6',
        'tren_6',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
