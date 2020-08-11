<?php

namespace Modules\GiangVien\Entities;

use Illuminate\Database\Eloquent\Model;

class LecturerByFl extends Model
{
    protected $fillable = [
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
