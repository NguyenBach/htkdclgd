<?php

namespace Modules\NghienCuuKhoaHoc\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class BangSangChe extends Model
{
    use LogsActivity;

    protected $table = 'bang_sang_che';

    protected $fillable = [
        'year',
        'university_id',
        'content'
    ];

    protected static $logAttributes = [
        'year',
        'university_id',
        'content'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
