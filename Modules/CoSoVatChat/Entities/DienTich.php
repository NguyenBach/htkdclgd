<?php

namespace Modules\CoSoVatChat\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class DienTich extends Model
{
    use LogsActivity;

    protected $table = 'dien_tich';

    protected $fillable = [
        'year',
        'university_id',
        'noi_dung',
        'dien_tich',
        'hinh_thuc'
    ];

    protected static $logAttributes = [
        'year',
        'university_id',
        'noi_dung',
        'dien_tich',
        'hinh_thuc'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'id'
    ];
}
