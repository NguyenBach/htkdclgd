<?php

namespace Modules\CoSoVatChat\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ThuChi extends Model
{
    use LogsActivity;

    protected $table = 'thu_chi';

    protected $fillable = [
        'university_id',
        'year',
        'tong_nguon_thu',
        'tong_hoc_phi',
        'chi_nckh',
        'thu_nckh',
        'chi_dao_tao',
        'chi_doi_ngu',
        'chi_ket_noi'
    ];

    protected static $logAttributes = [
        'university_id',
        'year',
        'tong_nguon_thu',
        'tong_hoc_phi',
        'chi_nckh',
        'thu_nckh',
        'chi_dao_tao',
        'chi_doi_ngu',
        'chi_ket_noi'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
