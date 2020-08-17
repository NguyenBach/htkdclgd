<?php

namespace Modules\NghienCuuKhoaHoc\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ThanhTich extends Model
{
    use LogsActivity;

    protected $table = 'thanh_tich_nckh';

    protected $fillable = [
        'year',
        'university_id',
        'giai_thuong',
        'bai_bao',

    ];

    protected static $logAttributes = [
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
