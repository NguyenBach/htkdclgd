<?php

namespace Modules\NghienCuuKhoaHoc\Entities;

use Illuminate\Database\Eloquent\Model;

class BaoCaoHoiThao extends Model
{
    protected $table = 'bao_cao_tai_hoi_thao';
    protected $fillable = [
        'year',
        'university_id',
        'phan_loai_hoi_thao_id',
        'so_luong'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
