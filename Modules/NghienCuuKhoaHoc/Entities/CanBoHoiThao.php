<?php

namespace Modules\NghienCuuKhoaHoc\Entities;

use Illuminate\Database\Eloquent\Model;

class CanBoHoiThao extends Model
{
    protected $table = 'sl_cb_tren_hoi_thao';
    protected $fillable = [
        'university_id',
        'year',
        'tu_1_5',
        'tu_5_10',
        'tu_11_15',
        'tren_15'
    ];
}
