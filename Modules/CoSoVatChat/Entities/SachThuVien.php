<?php

namespace Modules\CoSoVatChat\Entities;

use Illuminate\Database\Eloquent\Model;

class SachThuVien extends Model
{
    protected $table = 'sach_thu_vien';
    protected $fillable = [
        'year',
        'university_id',
        'nhom_nganh_id',
        'dau_sach',
        'ban_sach'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function nhomNganh()
    {
        return $this->belongsTo(NhomNganh::class, 'nhom_nganh_id', 'id');
    }
}
