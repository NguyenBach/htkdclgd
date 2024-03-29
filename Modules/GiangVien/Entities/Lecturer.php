<?php

namespace Modules\GiangVien\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Lecturer extends Model
{
    use LogsActivity;

    protected $fillable = [
        'university_id',
        'year',
        'lecturer_type',
        'total_1',
        'percent_doctor_1',
        'total_2',
        'percent_doctor_2'
    ];

    protected static $logAttributes = [
        'university_id',
        'year',
        'lecturer_type',
        'total_1',
        'percent_doctor_1',
        'total_2',
        'percent_doctor_2'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'lecturer_type'
    ];
}
