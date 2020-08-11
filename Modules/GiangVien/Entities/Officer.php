<?php

namespace Modules\GiangVien\Entities;

use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    protected $fillable = [
        'university_id',
        'year',
        'quan_ly_co_huu',
        'quan_ly_hop_dong',
        'nhan_vien_co_huu',
        'nhan_vien_hop_dong'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
