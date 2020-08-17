<?php

namespace Modules\NghienCuuKhoaHoc\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SvNCKH extends Model
{
    use LogsActivity;

    protected $table = 'sv_va_nckh';

    protected $fillable = [
        'university_id',
        'year',
        'tu_1_3',
        'tu_4_6',
        'tren_6',
        'cap_de_tai_id'
    ];

    protected static $logAttributes = [
        'university_id',
        'year',
        'tu_1_3',
        'tu_4_6',
        'tren_6',
        'cap_de_tai_id'
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];
}
