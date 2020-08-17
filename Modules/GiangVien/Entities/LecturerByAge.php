<?php

namespace Modules\GiangVien\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class LecturerByAge extends Model
{
    use LogsActivity;

    protected $fillable = [
        'university_id',
        'year',
        'total',
        'percent',
        'lecturer_degree',
        'lecturer_man',
        'lecturer_woman',
        'less_30',
        'less_40',
        'less_50',
        'less_60',
        'over_60',
        'avg_age'
    ];

    protected static $logAttributes = [
        'university_id',
        'year',
        'total',
        'percent',
        'lecturer_degree',
        'lecturer_man',
        'lecturer_woman',
        'less_30',
        'less_40',
        'less_50',
        'less_60',
        'over_60',
        'avg_age'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
