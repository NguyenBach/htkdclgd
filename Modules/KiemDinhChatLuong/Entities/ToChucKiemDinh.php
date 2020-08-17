<?php

namespace Modules\KiemDinhChatLuong\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ToChucKiemDinh extends Model
{
    use LogsActivity;

    protected $table = 'to_chuc_kiem_dinh';

    protected $fillable = [
        'name'
    ];
    protected static $logAttributes = [
        'name'
    ];

}
