<?php

namespace Modules\NghienCuuKhoaHoc\Entities;

use Illuminate\Database\Eloquent\Model;

class CanBoHoiThao extends Model
{
    protected $table = 'sl_bc_tren_hoi_thao';
    protected $fillable = [
        'university_id',
        'phan_loai_hoi_thao_id',
        'year',
        'tu_1_5',
        'tu_5_10',
        'tu_11_15',
        'tren_15'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
