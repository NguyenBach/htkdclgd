<?php

namespace Modules\NghienCuuKhoaHoc\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class BaoCaoHoiThao extends Model
{
    use LogsActivity;

    protected $table = 'bao_cao_tai_hoi_thao';
    protected $fillable = [
        'year',
        'university_id',
        'phan_loai_hoi_thao_id',
        'so_luong'
    ];
    protected static $logAttributes = [
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
