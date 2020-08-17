<?php

namespace Modules\NguoiHoc\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SvNhapHoc extends Model
{
    use LogsActivity;

    protected $table = 'sv_nhap_hoc';

    protected $fillable = [
        'year',
        'university_id',
        'he_hoc',
        'type',
        'sl_du_tuyen',
        'sl_trung_tuyen',
        'sl_nhap_hoc',
        'ty_le_canh_tranh',
        'sl_sv_quoc_te',
        'diem_dau_vao',
        'diem_trung_binh'
    ];

    protected static $logAttributes = [
        'he_hoc',
        'type',
        'sl_du_tuyen',
        'sl_trung_tuyen',
        'sl_nhap_hoc',
        'ty_le_canh_tranh',
        'sl_sv_quoc_te',
        'diem_dau_vao',
        'diem_trung_binh'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
