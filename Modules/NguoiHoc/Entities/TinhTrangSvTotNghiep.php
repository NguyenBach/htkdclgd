<?php

namespace Modules\NguoiHoc\Entities;

use Illuminate\Database\Eloquent\Model;

class TinhTrangSvTotNghiep extends Model
{
    protected $table = 'tinh_trang_sv_tn';

    protected $fillable = [
        'university_id',
        'year',
        'he_hoc',
        'tra_loi',
        'cau_hoi_id'
    ];

    public function cauHoi()
    {
        return $this->belongsTo(CauHoiTotNghiep::class, 'cau_hoi_id')
            ->with('group');
    }
}
