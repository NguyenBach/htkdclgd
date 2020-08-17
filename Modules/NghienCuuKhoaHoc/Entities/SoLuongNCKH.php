<?php

namespace Modules\NghienCuuKhoaHoc\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SoLuongNCKH extends Model
{
    use LogsActivity;

    protected $table = 'so_luong_nckh';
    protected $fillable = [
        'university_id',
        'year',
        'dt_cap_nha_nuoc',
        'dt_cap_bo',
        'dt_cap_truong'
    ];
    protected static $logAttributes = [
        'university_id',
        'year',
        'dt_cap_nha_nuoc',
        'dt_cap_bo',
        'dt_cap_truong'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
