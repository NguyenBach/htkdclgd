<?php

namespace Modules\KiemDinhChatLuong\Entities;

use Illuminate\Database\Eloquent\Model;

class DoiTuongKiemDinh extends Model
{
    protected $table = 'doi_tuong_kiem_dinhs';

    protected $fillable = [
        'university_id',
        'name'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
