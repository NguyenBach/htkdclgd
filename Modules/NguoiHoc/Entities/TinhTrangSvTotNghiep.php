<?php

namespace Modules\NguoiHoc\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class TinhTrangSvTotNghiep extends Model
{
    use LogsActivity;

    protected $table = 'tinh_trang_sv_tn';

    protected $fillable = [
        'university_id',
        'year',
        'he_hoc',
        'tra_loi',
        'cau_hoi_id'
    ];

    protected static $logAttributes = [
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
