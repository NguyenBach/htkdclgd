<?php

namespace Modules\KiemDinhChatLuong\Entities;

use Illuminate\Database\Eloquent\Model;

class TieuChuanKiemDinh extends Model
{
    protected $table = 'tieu_chuan_kiem_dinhs';

    protected $fillable = [
        'name'
    ];

}
