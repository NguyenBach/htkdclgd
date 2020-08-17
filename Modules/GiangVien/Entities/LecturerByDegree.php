<?php

namespace Modules\GiangVien\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class LecturerByDegree extends Model
{
    use LogsActivity;

    protected $fillable = [
        'university_id',
        'year',
        'lecturer_type',
        'professor',
        'associate_professor',
        'science_doctor',
        'doctor',
        'master',
        'undergraduate',
        'college',
        'intermediate',
        'other',
    ];

    protected static $logAttributes = [
        'university_id',
        'year',
        'lecturer_type',
        'professor',
        'associate_professor',
        'science_doctor',
        'doctor',
        'master',
        'undergraduate',
        'college',
        'intermediate',
        'other',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
