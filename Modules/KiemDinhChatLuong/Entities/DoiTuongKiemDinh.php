<?php

namespace Modules\KiemDinhChatLuong\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class DoiTuongKiemDinh extends Model
{
    use LogsActivity;

    protected $table = 'doi_tuong_kiem_dinhs';

    protected static $logAttributes = [
        'university_id',
        'name'
    ];

    protected $fillable = [
        'university_id',
        'name'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
