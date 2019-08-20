<?php

namespace Modules\KiemDinhChatLuong\Entities;

use Illuminate\Database\Eloquent\Model;

class ToChucKiemDinh extends Model
{
    protected $table = 'to_chuc_kiem_dinh';

    protected $fillable = [
        'name'
    ];
}
