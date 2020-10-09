<?php

namespace Modules\KiemDinhChatLuong\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class KiemDinhChatLuong extends Model
{
    use LogsActivity;

    protected $table = 'kiem_dinh_chat_luongs';

    protected $fillable = [
        'university_id',
        'year',
        'type',
        'doi_tuong',
        'bo_tieu_chuan',
        'nam_hoan_thanh_1',
        'nam_cap_nhat',
        'to_chuc',
        'nam_danh_gia',
        'ket_qua',
        'ngay_cap',
        'gia_tri_den'
    ];

    protected static $logAttributes = [
        'university_id',
        'doi_tuong',
        'bo_tieu_chuan',
        'nam_hoan_thanh_1',
        'nam_cap_nhat',
        'to_chuc',
        'nam_danh_gia',
        'ket_qua',
        'ngay_cap',
        'gia_tri_den'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function doiTuongKiemDinh()
    {
        return $this->hasOne(DoiTuongKiemDinh::class, 'id', 'doi_tuong');
    }

    public function toChucKiemDinh()
    {
        return $this->hasOne(ToChucKiemDinh::class, 'id', 'to_chuc');
    }

    public function tieuChuanKiemDinh()
    {
        return $this->hasOne(TieuChuanKiemDinh::class, 'id', 'bo_tieu_chuan');
    }
}
