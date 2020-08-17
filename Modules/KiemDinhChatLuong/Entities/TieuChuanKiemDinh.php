<?php

namespace Modules\KiemDinhChatLuong\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class TieuChuanKiemDinh extends Model
{
    use LogsActivity;

    protected $table = 'tieu_chuan_kiem_dinhs';

    protected $fillable = [
        'name'
    ];

    protected static $logAttributes = [
        'name'
    ];

}
