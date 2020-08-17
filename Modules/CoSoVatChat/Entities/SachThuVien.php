<?php

namespace Modules\CoSoVatChat\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SachThuVien extends Model
{
    use LogsActivity;

    protected $table = 'sach_thu_vien';

    protected $fillable = [
        'year',
        'university_id',
        'nhom_nganh_id',
        'dau_sach',
        'ban_sach'
    ];

    protected static $logAttributes = [
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
