<?php

namespace Modules\ThongTinChung\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Branch extends Model
{
    use LogsActivity;

    protected $fillable = [
        'university_id',
        'name',
        'founded_year',
        'field',
        'number_researcher',
        'number_officer',
        'slug'
    ];

    protected static $logAttributes= [
        'name',
        'founded_year',
        'field',
        'number_researcher',
        'number_officer',
        'slug'
    ];

    protected $hidden = [
        'created_at',
        'slug',
        'updated_at'
    ];
}
