<?php

namespace Modules\GiangVien\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class LecturerByFl extends Model
{
    use LogsActivity;

    protected $fillable = [
        'university_id',
        'year',
        'frequency',
        'foreign_language',
        'information_technology'
    ];

    protected static $logAttributes = [
        'university_id',
        'year',
        'frequency',
        'foreign_language',
        'information_technology'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
